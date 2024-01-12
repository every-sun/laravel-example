<template>
    <Layout :title="data?'게시글 수정':'게시글 작성'">
        <form class="flex flex-col h-full justify-between" @submit.prevent="submit">
                <div>
                    <div class="flex gap-1 mb-3">
                        <Input v-model="form.title" name="제목" :error="form.errors.title"/>
                    </div>
                    <TextArea v-model="form.content" name="내용" :error="form.errors.content"/>
                </div>
            <Button title="전송"/>
        </form>
        <Modal ref="modalRef"/>
    </Layout>
</template>
<script setup>
import Layout from "@/Pages/Components/Layout.vue";
import { onUpdated, ref } from "vue";
import Button from "@/Pages/Components/Button.vue";
import Modal from "@/Pages/Components/Modal.vue";
import Input from "@/Pages/Components/Input.vue";
import TextArea from "@/Pages/Components/TextArea.vue";
import usePost from "@/libs/controller/usePost.js";
import { useForm } from "@inertiajs/vue3";

const props = defineProps(
    {
        data: Object || null || undefined,
    }
)
const modalRef = ref(null)
const {storePost, updatePost} = usePost({modalRef});

const form = useForm({
    title : props.data?.title,
    content: props.data?.content,
    writer: props.data?.writer,
})

const submit = () => {
    if(props.data===null || props.data===undefined){
        storePost({form})
    }else{
        updatePost({form, id: props.data.id})
    }
}

</script>
