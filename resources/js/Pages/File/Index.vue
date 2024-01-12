<template>
    <Layout title="파일 모음">
       <div class="h-full">
           <div class="flex-wrap flex gap-1 h-[90%] bg-red-100">
               <ImageCard v-for="item in data.data" :key="item.id" :file="item" />
           </div>
           <PaginationButtons :links="data.links" />
       </div>
    </Layout>
</template>
<script setup>
import Layout from "@/Pages/Components/Layout.vue";
import ImageCard from "@/Pages/File/Patials/ImageCard.vue";
import PaginationButtons from "@/Pages/Components/PaginationButtons.vue";

const props = defineProps({
    data: Object
});

console.log('files: ', props.data);
</script>
