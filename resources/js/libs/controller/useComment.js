import {router} from '@inertiajs/vue3';
import { inject } from "vue";
import useModal from "../useModal.js";
export default function useComment({modalRef}){
    const route = inject('route');
    const modal = useModal({modalRef});
    const storeComment = ({content, parent_id}) => {
        router.post(route('post.comment.store', {post_id: route().params.id}), {content, parent_id});
    }

    const updateComment = ({id, content}) => {
        router.put(route('post.comment.update', {post_id: route().params.id, id: id}), {content})
    }

    const destroyComment = (id) => {
        if(modalRef===null){
            return;
        }
        modal.openModal({
            content: '댓글을 삭제하시겠습니까?',
            event: ()=>{
                router.delete(route('post.comment.destroy', {post_id: route().params.id, id: id}));
            }
        })
    }

    const storeLike = ({id}) => {
        router.post(route('comment.like.store', {comment_id:id}));
    }

    const destroyLike = ({id}) => {
        router.delete(route('comment.like.destroy', {comment_id:id}));
    }

    return {
        storeComment,
        updateComment,
        destroyComment,
        storeLike,
        destroyLike
    };
}
