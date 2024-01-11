<template>
    <Layout :title="route().current('user.comments.likes.index')?`좋아한 댓글${data.total>0?`(${data.total})`:''}`:`내 댓글${data.total>0?`(${data.total})`:''}`">
        <div class="w-full flex flex-col justify-between items-center h-full">
            <ul class="w-full h-[90%] justify-center overflow-y-auto">
                <CommentItem v-for="comment in data.data" :item="comment" :key="comment.id" :auth="auth" @destroy-comment="destroyComment"/>
            </ul>
            <PaginationButtons :links="props.data.links"/>
        </div>
        <Modal ref="modalRef"/>
    </Layout>
</template>
<script setup>
import Layout from "@/Pages/Components/Layout.vue";
import CommentItem from "@/Pages/MyPage/Patials/CommentItem.vue";
import PaginationButtons from "@/Pages/Components/PaginationButtons.vue";
import { inject, ref } from "vue";
import usePost from "@/libs/controller/usePost.js";
import useComment from "@/libs/controller/useComment.js";
import Modal from "@/Pages/Components/Modal.vue";

const props = defineProps({
    data: Object,
    auth: Object || null || undefined,
})
const route = inject('route')

const modalRef = ref(null);

const {destroyComment} = useComment({modalRef});

</script>

