<template>
    <div class="py-1 flex flex-col gap-2 pb-20">
        <ul class="flex flex-col gap-2">
            <li class="border-b border-gray-300" v-for="item in data.data" :key="item.id">
                <div v-if="editableId!==item.id">
                    <div class="flex justify-between flex-col">
                        <p class="text-xs">
                            {{ item.user.name }}
                        </p>
                    </div>
                    <p class="py-2">
                        {{ item.content }}
                    </p>
                    <div v-if="parentId===item.id" class="flex gap-6 w-full pl-10">
                        <ChatBubbleLeftEllipsisIcon class="w-10"/>
                        <CommentForm class="w-full" :hint-text="`${item.user.name}님에게 답글 입력중...`" :parent-id="parentId" @submit-success="parentId=null"/>
                    </div>
                    <div v-else class="flex gap-1.5 py-1" v-if="item.user.id===auth?.user?.id">
                        <p class="text-xs text-gray-500">{{ getShortTime(item.created_at) }}</p>
                        <TextButton title="답글달기" size="text-xs" @event="parentId = item.id" />
                        <TextButton title="수정" size="text-xs" @event="editableId = item.id"/>
                        <TextButton title="삭제" size="text-xs" @event="emits('destroyComment', item.id)"/>
                        <TextButton :title="`좋아요${item.likes_count>0?`(${item.likes_count})`:''}`" size="text-xs" @event="likeToggle(item.id)"><template v-slot:icon><HeartIcon class="w-[16px]" :class="[user_like_comments.includes(item.id) && 'text-red-500']" /></template></TextButton>
                    </div>
                    <div v-for="reply in item.replies" :key="reply.id" >
                        <ReplyItem v-if="editableId!==reply.id" :item="reply" :auth="auth">
                            <template v-slot:buttons>
                                <TextButton title="수정" size="text-xs" @event="editableId = reply.id"/>
                                <TextButton class="ml-1" title="삭제" size="text-xs" @event="emits('destroyComment', reply.id)"/>
                            </template>
                        </ReplyItem>
                        <CommentForm class="p-2 pl-10" v-else :data="reply" @submit-success="editableId=null" />
                    </div>
                </div>
                <CommentForm v-else :data="item" @submit-success="editableId=null" />
            </li>
        </ul>
    </div>
</template>
<script setup>
import { ref } from "vue";
import CommentForm from "@/Pages/Post/Show/Patials/CommentForm.vue";
import {ChatBubbleLeftEllipsisIcon, HeartIcon} from "@heroicons/vue/24/solid/index.js";
import useUtils from "@/libs/useUtils.js";
import ReplyItem from "@/Pages/Post/Show/Patials/ReplyItem.vue";
import TextButton from "@/Pages/Components/TextButton.vue";
import useComment from "@/libs/controller/useComment.js";

const props = defineProps({
    data: Object,
    auth: Object || null || undefined,
    user_like_comments: Object
})

const { storeLike, destroyLike } = useComment({modalRef: null});
const { getShortTime } = useUtils();

const editableId = ref(null);
const parentId = ref(null);

const emits = defineEmits(['destroyComment']);

const likeToggle = (id) => {
    if(props.user_like_comments.includes(id)){
        destroyLike({id});
    }else{
        storeLike({id});
    }
}



</script>
