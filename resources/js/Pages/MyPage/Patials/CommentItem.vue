<template>
    <li class="w-full border-b border-gray-300" >
        <div>
            <div class="flex justify-between flex-col">
              <TextButton :title="item.post.title" @event="showPost({id: item.post.id})"/>
            </div>
            <p>
                {{ item.content }}
            </p>
            <TextButton v-if="item.user.id===auth?.user?.id" title="삭제" size="text-xs" @event="emits('destroyComment', item.id)" />
            <div class="flex gap-1.5 py-1">
                <p class="text-xs text-gray-500">{{ getShortTime(item.created_at) }}</p>
                <TextButton v-if="route().current('user.comments.likes.index')" :title="`좋아요${item.likes_count>0?`(${item.likes_count})`:''}`" size="text-xs" @event="destroyLike({id: item.id})"><template v-slot:icon><HeartIcon class="w-[16px] text-red-500" /></template></TextButton>
                <p v-else class="text-xs text-gray-500">좋아요 ({{ item.likes_count }})</p>
            </div>
        </div>
    </li>
</template>
<script setup>
import useUtils from "@/libs/useUtils.js";
import TextButton from "@/Pages/Components/TextButton.vue";
import { HeartIcon } from "@heroicons/vue/24/solid/index.js";
import useComment from "@/libs/controller/useComment.js";
import usePost from "@/libs/controller/usePost.js";
import { inject } from "vue";

const props = defineProps({
    item: Object,
    auth: Object || null || undefined,
})

const emits = defineEmits(['destroyComment']);

const { getShortTime } = useUtils();
const { destroyLike } = useComment({modalRef: null});
const {showPost} = usePost({modalRef: null});

const route = inject('route')

</script>

