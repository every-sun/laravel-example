<template>
    <Layout :title="pageTitle">
        <div class="w-full flex flex-col h-full justify-between items-center">
            <table class="w-full divide-y divide-gray-300 border-2 justify-center h-[90%]">
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
                        <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500" @click="showPost({id: post.id})">{{ (route().params.page && route().params.page>1)?(parseInt(route().params.page)*10)+(i+1):(i+1) }}</td>
                        <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500 hover:font-semibold" @click="showPost({id: post.id})">
                            <span>{{ post.title }}</span><span v-if="post.comments_count > 0">{{` (${post.comments_count})` }}</span></td>
                        <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500" @click="showPost({id: post.id})">{{ post.user.name }}</td>
                        <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500" @click="showPost({id: post.id})">{{ getShortTime(post.created_at) }}</td>
                        <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500" v-if="post.user_id===auth?.user?.id">
                            <div class="flex gap-1">
                                <TextButton @event="editPostPage({id: post.id})" title="수정" />
                                <TextButton @event="destroyPost({id: post.id})" title="삭제" />
                            </div>
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
import { computed, inject, ref } from "vue";
import PaginationButtons from "../Components/PaginationButtons.vue";
import Button from "@/Pages/Components/Button.vue";
import usePost from "@/libs/controller/usePost.js";
import useUtils from "@/libs/useUtils.js";
import Modal from "@/Pages/Components/Modal.vue";
import TextButton from "@/Pages/Components/TextButton.vue";

const props = defineProps({
    data: Object,
    auth: Object || null || undefined,
})

console.log(props.data);

const route = inject('route');

const { getShortTime } = useUtils();

const modalRef = ref(null);

const {editPostPage, destroyPost, showPost} = usePost({modalRef});

console.log(route().params.page);

const pageTitle = computed(()=>{
    if(route().current('user.posts.index')){
        return `내 게시글${props.data.total>0?`(${props.data.total})`:''}`
    }if(route().current('user.bookmarks.index')){
        return `북마크${props.data.total>0?`(${props.data.total})`:''}`
    }else{
        return '게시글 목록';
    }
})

</script>

