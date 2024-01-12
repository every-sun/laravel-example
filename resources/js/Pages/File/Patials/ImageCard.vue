<template>
    <div ref="divRef" class="w-48 h-60 text-center flex flex-col justify-between p-2 border-2 gap-1">
        <div class="h-[90%] overflow-hidden">
            <img :src="`/storage/${file.images[0]}`" :alt="`${file.images[0]}`" class="h-[100%] object-cover w-full"/>
        </div>
        <p class="text-ellipsis overflow-clip">{{ file.name }}</p>
        <Button title="다운로드" @event="onDownloadAllFiles">
            <template v-slot:icon>
                <ArrowDownTrayIcon class="w-4"/>
            </template>
        </Button>
    </div>
</template>
<script setup>

import Button from "@/Pages/Components/Button.vue";
import { ref } from "vue";
import {ArrowDownTrayIcon} from "@heroicons/vue/24/outline/index.js";

const props = defineProps({
    file: Object
})

const divRef = ref('null');

const onDownloadAllFiles = () => {
    const urls = props.file.images;

    const link = document.createElement('a');
    link.style.display = 'none';
    divRef.value.appendChild(link);

    urls.forEach((value, i)=>{
        link.setAttribute('href', `/storage/${value}`);
        link.setAttribute('download', `${props.file.name}${i>0?i:''}`);
        link.click();
    })

    divRef.value.removeChild(link);

}

</script>
