<template>
    <Layout title="게시글 상세">
        <div>
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
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ data.content }}</dd>
                    </div>
                </dl>
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

const props = defineProps(
    {
        data: Object,
        auth: Object || null || undefined
    }
)

const modalRef = ref(null);

const {editPostPage, destroyPost} = usePost({modalRef})

const { getLongTime } = useUtils();

</script>
