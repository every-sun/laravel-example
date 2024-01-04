<template>
    <form class="flex flex-col gap-6" @submit.prevent="submitComment">
        <TextArea name="댓글을 입력해주세요" :rows="3" v-model="content"/>
        <Button :title="data?'수정':'등록'" />
    </form>
</template>
<script setup>
import TextArea from "@/Pages/Components/TextArea.vue";
import Button from "@/Pages/Components/Button.vue";
import { ref } from "vue";
import useComment from "@/libs/controller/useComment.js";
const props = defineProps(
    {
        data: Object || null || undefined
    }
)

const content = ref(props.data?props.data.content:null);

const emits = defineEmits(['updateSuccess'])

const {updateComment, storeComment} = useComment({modalRef:null});
const submitComment = () => {
    if(props.data){
        updateComment({id: props.data.id, content: content.value});
        content.value = null;
        emits('updateSuccess');
    }else{
        storeComment({content: content.value});
        content.value = null;
    }
}

</script>
