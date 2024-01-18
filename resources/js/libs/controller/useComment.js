import {router} from '@inertiajs/vue3';
import { inject } from "vue";
import useModal from "../useModal.js";
export default function useComment({modalRef}){
    const route = inject('route');
    const modal = useModal({modalRef});
    const storeComment = ({form}) => {
        form.post(route('post.comment.store', {post_id: route().params.id}), {
            preserveScroll: true,
            onSuccess: (res) => {
                console.log('댓글저장: ', res)
                form.reset('content');

                modal.openModal({
                    content:'1',
                    event: ()=>{

                    }
                })
            },
            onFinish: (visit)=>{
                console.log(visit)
            },
            onError: (errors)=>{
                console.log(errors.content)
            }
        });
    }

    const updateComment = ({id, form}) => {
        form.put(route('post.comment.update', {post_id: route().params.id, id: id}), {
            preserveScroll: true,
            onSuccess: () => form.reset('content'),
            onError: (error)=>{
                console.log(error.content)
            }
        })
    }

    const destroyComment = ({id, post_id}) => {
        if(modalRef===null){
            return;
        }
        modal.openModal({
            content: '댓글을 삭제하시겠습니까?',
            event: ()=>{
                router.delete(route('post.comment.destroy', {post_id, id}));
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
        destroyLike,
    };
}
