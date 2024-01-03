<template>
    <Layout title="게시글 목록">
        <div class="w-full flex flex-col h-full justify-between items-center">
            <table class="w-full divide-y divide-gray-300 border-2 justify-center">
                <thead>
                    <tr class="w-full">
                        <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900 w-[10%] ">번호</th>
                        <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900 w-[50%]">제목</th>
                        <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900 w-[25%]">작성자</th>
                        <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900 w-[15%]">작성일</th>
                        <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900 w-[15%]"></th>
                    </tr>
                </thead>
                <tbody class="bg-white" v-if="data.data?.length===0">
                    <tr>
                        <td colspan="4" class="p-4 h-96 text-sm text-center text-gray-400">
                            게시글이 존재하지 않습니다.
                        </td>
                    </tr>
                </tbody>
                <tbody v-else class="divide-y divide-gray-200 bg-white">
                    <tr v-for="(post, i) in data.data" :key="post.id" class="cursor-pointer hover:bg-yellow-50">
                        <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500" @click="showPost(post.id)">{{ i+1 }}</td>
                        <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500" @click="showPost(post.id)">{{ post.title }}</td>
                        <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500" @click="showPost(post.id)">{{ post.user.name }}</td>
                        <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500" @click="showPost(post.id)">{{ getPostCreatedTime(post.created_at) }}</td>
                        <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500 flex gap-1" v-if="post.user_id===auth?.user?.id">
                            <button @click="editPostPage({id: post.id})">수정</button>
                            <button @click="destroyPost({id: post.id})">삭제</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <PaginationButtons :links="props.data.links"/>
            <Modal ref="modalRef"/>
        </div>
    </Layout>
</template>
<script setup>
import Layout from "@/Pages/Components/Layout.vue";
import {router} from "@inertiajs/vue3";
import { inject, ref } from "vue";
import PaginationButtons from "../Components/PaginationButtons.vue";
import Button from "@/Pages/Components/Button.vue";
import usePost from "@/libs/controller/usePost.js";
import useUtils from "@/libs/useUtils.js";
import Modal from "@/Pages/Components/Modal.vue";

const props = defineProps({
    data: Object,
    auth: Object || null || undefined,
})

const route = inject('route');

const { getPostCreatedTime } = useUtils();

const modalRef = ref(null);

const {editPostPage, destroyPost} = usePost({modalRef});

const showPost = (id) => {
    router.get(route('post.show', {id: id}));
}

console.log(props.data);

</script>

