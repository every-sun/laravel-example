<template>
    <form class="flex flex-col gap-6" @submit.prevent="submitComment">
        <TextArea :name="hintText?hintText:'댓글을 입력해주세요'" :rows="3" v-model="form.content" :error="form.errors?.content"/>
        <Button :title="data?'수정':'등록'" />
    </form>
    <Modal ref="modalRef"/>

</template>
<script setup>
import TextArea from "@/Pages/Components/TextArea.vue";
import Button from "@/Pages/Components/Button.vue";
import { ref } from "vue";
import useComment from "@/libs/controller/useComment.js";
import { useForm } from "@inertiajs/vue3";
import Modal from "@/Pages/Components/Modal.vue";

const props = defineProps( {
    data: Object || null || undefined,
    hintText: String || null || undefined,
    parentId: Number || null || undefined
} )

const modalRef = ref(null);

const form = useForm({
    content: props.data?props.data.content:null,
    parent_id: props.parentId
})

const emits = defineEmits(['submitSuccess'])

const {updateComment, storeComment} = useComment({modalRef:modalRef});
const submitComment = () => {
    if(props.data){
        updateComment({id: props.data.id, form});
    }else{
        storeComment({form});
    }
    emits('submitSuccess');
}

</script>
