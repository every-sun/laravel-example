<template>
    <div class="py-1 flex flex-col gap-2">
        <h1 class="">총 댓글</h1>
        <ul class="flex flex-col gap-2 divide-y divide-gray-200">
            <li class="py-2" v-for="item in data" :key="item.id">
                <div v-if="editableId!==item.id">
                    <div class="flex justify-between">
                        <p class="text-xs">
                            {{ item.user.name }}
                        </p>
                        <p class="text-xs text-gray-500">{{ getShortTime(item.created_at) }}</p>
                    </div>
                    <p>
                        {{ item.content }}
                    </p>
                    <div class="flex gap-1 justify-end" v-if="item.user.id===auth?.user?.id">
                        <Button title="수정" size="text-xs" @event="editableId = item.id"/>
                        <Button title="삭제" size="text-xs" @event="emits('destroyComment', {id: item.id})"/>
                    </div>
                </div>
                <CommentForm v-else :data="item" @update-success="editableId=null" />
            </li>
        </ul>
    </div>
</template>
<script setup>
import { ref } from "vue";
import CommentForm from "@/Pages/Post/Show/Patials/CommentForm.vue";
import Button from "@/Pages/Components/Button.vue";
import useUtils from "@/libs/useUtils.js";

const props = defineProps({
    data: Object,
    auth: Object || null || undefined
})

const editableId = ref(null);
const { getShortTime } = useUtils();
const emits = defineEmits(['destroyComment']);


</script>
