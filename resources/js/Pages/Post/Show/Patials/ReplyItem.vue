<template>
    <li v-if="editableId!==item.id" class="p-2 pl-10 border-gray-200 border-b flex gap-6 items-center">
        <p>↳</p>
        <div class="flex flex-col w-full">
            <div class="flex gap-6">
                <p class="text-xs">
                    {{ item.user.name }}
                </p>
                <p class="text-xs text-gray-500">{{ getShortTime(item.created_at) }}</p>
            </div>
            <p class="py-2">
                {{ item.content }}
            </p>
            <div class="items-center flex" v-if="item.user.id===auth?.user?.id">
                <slot name="buttons"></slot>
            </div>
        </div>
    </li>
</template>
<script setup>
import { ref } from "vue";
import CommentForm from "@/Pages/Post/Show/Patials/CommentForm.vue";
import {ChatBubbleLeftEllipsisIcon} from "@heroicons/vue/24/solid/index.js";
import useUtils from "@/libs/useUtils.js";
import Button from "@/Pages/Components/Button.vue";

const props = defineProps({
    item: Object,
    auth: Object || null || undefined,
})

const { getShortTime } = useUtils();

const editableId = ref(null);

</script>
