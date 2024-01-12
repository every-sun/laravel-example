<template>
    <div ref="divRef" class="w-48 h-64 text-center flex flex-col justify-between p-2 border-2 gap-1">
        <div class="h-full overflow-hidden cursor-pointer" @click="emits('showImages', file.images)">
            <img :src="`/storage/${file.images[0]}`" :alt="`${file.images[0]}`" class="h-[87%] object-cover w-full"/>
            <p class="text-ellipsis overflow-clip">{{ file.name }}</p>
        </div>
        <Button :title="`다운로드${file.images.length>1?`(${file.images.length})`:''}`" @event="onDownloadAllFiles">
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
import ShowPopup from "@/Pages/File/Patials/ShowPopup.vue";

const props = defineProps({
    file: Object
})

const divRef = ref('null');

const emits = defineEmits(['showImages'])

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
