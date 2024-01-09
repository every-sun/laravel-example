<template>
    <form class="flex flex-col gap-6" @submit.prevent="submitComment">
        <TextArea :name="hintText?hintText:'댓글을 입력해주세요'" :rows="3" v-model="content"/>
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
        data: Object || null || undefined,
        hintText: String || null || undefined,
        parentId: Number || null || undefined
    }
)

const content = ref(props.data?props.data.content:null);

const emits = defineEmits(['submitSuccess'])

const {updateComment, storeComment} = useComment({modalRef:null});
const submitComment = () => {
    if(props.data){
        updateComment({id: props.data.id, content: content.value});
        content.value = null;
    }else{
        console.log('대댓글 작성');
        storeComment({content: content.value, parent_id: props.parentId});
        content.value = null;
    }
    emits('submitSuccess');
}

</script>
