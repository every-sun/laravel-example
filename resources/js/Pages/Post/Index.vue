<template>
    <Layout title="게시글 목록">
        <div class="w-full flex flex-col h-full justify-between items-center">
            <table class="w-full divide-y divide-gray-300 border-2">
                <thead>
                <tr class="w-full">
                    <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900 w-[10%] ">번호</th>
                    <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900 w-[50%]">제목</th>
                    <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900 w-[25%]">작성자</th>
                    <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900 w-[15%]">작성일</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                <tr v-for="(post, i) in data.data" :key="post.id" class="cursor-pointer hover:bg-yellow-50" @click="showPost(post.id)">
                    <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{ i+1 }}</td>
                    <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{ post.title }}</td>
                    <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{ post.writer }}</td>
                    <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{ getPostCreatedTime(post.created_at) }}</td>
                </tr>
                </tbody>
            </table>
            <PaginationButtons :links="props.data.links"/>
        </div>
    </Layout>
</template>
<script setup>
import Layout from "@/Pages/Components/Layout.vue";
import {router} from "@inertiajs/vue3";
import { inject } from "vue";
import PaginationButtons from "../Components/PaginationButtons.vue";
import useUtils from "@/libs/useUtils.js";

const props = defineProps({
    data: Object
})
const route = inject('route');
const { getPostCreatedTime } = useUtils();

const showPost = (id) => {
    router.get(route('post.show', {id: id}));
}

</script>

