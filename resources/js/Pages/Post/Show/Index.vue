<template>
    <Layout title="게시글 상세">
        <div class="pb-6 w-[90%] mx-auto">
            <div class="px-4 sm:px-0 flex justify-between">
                <h3 class="text-base font-semibold leading-7 text-gray-900">{{ data.title }}</h3>
                <div class="flex gap-2" v-if="data.user_id===auth?.user?.id">
                    <Button title="수정" @event="editPostPage({id: data.id})"/>
                    <Button title="삭제" @event="destroyPost({id: data.id})"/>
                </div>
            </div>
            <div class="mt-6 border-t border-gray-100">
                <dl class="divide-y divide-gray-100">
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">작성자</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ data.user.name }}</dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">작성일</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ getLongTime(data.created_at) }}</dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">내용</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 break-words">{{ data.content }}</dd>
                    </div>
                </dl>
            </div>
            <div class="mt-3 py-4 border-t-2 border-gray-200 flex flex-col gap-10">
                <h1 class="font-medium text-sm">총 댓글 {{ data.comments_count }}</h1>
                <CommentForm />
                <CommentList :data="comments_data" @destroy-comment="destroyComment" :auth="auth"/>
                <PaginationButtons :links="comments_data.links" class="self-center"/>
            </div>
        </div>
        <Modal ref="modalRef"/>
    </Layout>
</template>
<script setup>
import Layout from "@/Pages/Components/Layout.vue";
import Button from "@/Pages/Components/Button.vue";
import { ref } from "vue";
import Modal from "@/Pages/Components/Modal.vue";
import usePost from "@/libs/controller/usePost.js";
import useUtils from "@/libs/useUtils.js";
import CommentForm from "@/Pages/Post/Show/Patials/CommentForm.vue";
import useComment from "@/libs/controller/useComment.js";
import CommentList from "@/Pages/Post/Show/Patials/CommentList.vue";
import PaginationButtons from "@/Pages/Components/PaginationButtons.vue";

const props = defineProps(
    {
        data: Object,
        auth: Object || null || undefined,
        comments_data: Object
    }
)

const modalRef = ref(null);

const {editPostPage, destroyPost} = usePost({modalRef});

const {destroyComment} = useComment({modalRef});

const { getLongTime } = useUtils();

</script>
