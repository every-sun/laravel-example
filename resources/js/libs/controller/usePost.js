import {router} from '@inertiajs/vue3';
import { inject } from "vue";
import useModal from "../useModal.js";
export default function usePost({modalRef}){
    const route = inject('route');
    const modal = useModal({modalRef});
    const storePost = ({form}) => {
        modal.openModal({
            content: '게시글을 등록하시겠습니까?',
            event: ()=>{
                router.post(route('post.store'), form);
            }
        })
    }

    const updatePost = ({id, form}) => {
        modal.openModal({
            content: '게시글을 수정하시겠습니까?',
            event: ()=>{
                router.put(route('post.update', {id: id}), form);
            }
        })
    }

    const editPostPage = ({id}) => {
        router.get(route('post.edit', {id: id}));
    }

    const destroyPost = ({id}) => {
        modal.openModal({
            content: '게시글을 정말 삭제하시겠습니까?',
            event: ()=>{
                router.delete(route('post.destroy', {id: id}));
            }
        })
    }

    return {
        storePost,
        updatePost,
        editPostPage,
        destroyPost
    };
}
