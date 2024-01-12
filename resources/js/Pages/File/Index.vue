<template>
    <Layout title="이미지 모음">
       <div class="h-full flex-col flex justify-between items-center ">
           <div class="h-[90%] grid grid-cols-5 gap-2">
               <ImageCard v-for="item in data.data" :key="item.id" :file="item" @show-images="setShowFileUrls"/>
           </div>
           <PaginationButtons :links="data.links" />
           <ShowPopup v-if="showFileUrls.length>0" :urls="showFileUrls" @on-close="showFileUrls=[]"/>
       </div>
    </Layout>
</template>
<script setup>
import Layout from "@/Pages/Components/Layout.vue";
import ImageCard from "@/Pages/File/Patials/ImageCard.vue";
import PaginationButtons from "@/Pages/Components/PaginationButtons.vue";
import ShowPopup from "@/Pages/File/Patials/ShowPopup.vue";
import { ref } from "vue";

const props = defineProps({
    data: Object
});

const showFileUrls = ref([]);

const setShowFileUrls = (urls) => {
    showFileUrls.value = urls;
}

</script>
