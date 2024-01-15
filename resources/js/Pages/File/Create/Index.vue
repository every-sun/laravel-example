<template>
    <Layout title="이미지 업로드">
        <div class="w-full flex gap-1">
            <form @submit.prevent="onSubmit" class="flex flex-col gap-2 w-full">
                <Input name="제목" v-model="form.name" />
                <input type="file" @change="onFileSelect($event.target.files)" multiple accept="image/*"/>
                <div class="grid grid-cols-5">
                    <img class="w-56 border-2 border-gray-200 p-2" v-for="url in imageUrls" :src="url" alt="이미지"/>
                </div>
                <Button title="전송" />
                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                    {{ form.progress.percentage }}%
                </progress>
            </form>
        </div>
    </Layout>
</template>
<script setup>
import Layout from "@/Pages/Components/Layout.vue";
import Input from "@/Pages/Components/Input.vue";
import { useForm } from "@inertiajs/vue3";
import Button from "@/Pages/Components/Button.vue";
import { inject, ref } from "vue";

const form = useForm({
    name: null,
    images: []
});
const route = inject('route');

const imageUrls = ref([]);
const onSubmit = () => {
    console.log(form.images);
    form.post(route('files.store'))
}

const onFileSelect = (files) => {
    Array.from( files ).forEach( ( i ) => {
        const blob = new Blob( [ i ] );
        imageUrls.value.push(URL.createObjectURL( blob ));
        URL.revokeObjectURL( blob );
    } );
    console.log('Array.from(files):', Array.from( files ));
    const prev = form.images.filter(()=>true);
    form.images = prev.concat(Array.from( files ))
    console.log('form.images:', form.images);

}
</script>
