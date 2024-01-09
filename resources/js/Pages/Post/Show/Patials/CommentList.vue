<template>
    <div class="py-1 flex flex-col gap-2">
        <ul class="flex flex-col gap-2">
            <li class="border-b border-gray-300" v-for="item in data.data" :key="item.id">
                <div v-if="editableId!==item.id">
                    <div class="flex justify-between">
                        <p class="text-xs">
                            {{ item.user.name }}
                        </p>
                        <p class="text-xs text-gray-500">{{ getShortTime(item.created_at) }}</p>
                    </div>
                    <p class="py-2">
                        {{ item.content }}
                    </p>
                    <div v-if="parentId===item.id" class="flex gap-6 w-full pl-10">
                        <ChatBubbleLeftEllipsisIcon class="w-10"/>
                        <CommentForm class="w-full" :hint-text="`${item.user.name}님에게 답글 입력중...`" :parent-id="parentId" @submit-success="parentId=null"/>
                    </div>
                    <div v-else class="flex gap-1 justify-end" v-if="item.user.id===auth?.user?.id">
                        <Button title="답글" size="text-xs" @event="parentId = item.id" />
                        <Button title="수정" size="text-xs" @event="editableId = item.id"/>
                        <Button title="삭제" size="text-xs" @event="emits('destroyComment', item.id)"/>
                    </div>
                    <div v-for="reply in item.replies" :key="reply.id" >
                        <ReplyItem :item="reply" :auth="auth"/>
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
import {ChatBubbleLeftEllipsisIcon} from "@heroicons/vue/24/solid/index.js";
import useUtils from "@/libs/useUtils.js";
import Button from "@/Pages/Components/Button.vue";
import ReplyItem from "@/Pages/Post/Show/Patials/ReplyItem.vue";

const props = defineProps({
    data: Object,
    auth: Object || null || undefined
})

const { getShortTime } = useUtils();

const editableId = ref(null);
const parentId = ref(null);

const emits = defineEmits(['destroyComment']);

</script>
