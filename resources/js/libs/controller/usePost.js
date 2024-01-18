import {router} from '@inertiajs/vue3';
import { inject } from "vue";
import useModal from "../useModal.js";
export default function usePost({modalRef}){
    const route = inject('route');
    const modal = useModal({modalRef});

    const showPost = ({id})=>{
        router.get(route('post.show', {id: id}));
    }
    const storePost = ({form}) => {
        if(modalRef===null){
            return;
        }
        modal.openModal({
            content: '게시글을 등록하시겠습니까?',
            event: ()=>{
                form.post(route('post.store'), {
                    onError: (errors)=>{
                        console.log(errors)
                    },
                    onSuccess: ()=>{

                    }
                })
            }
        })
    }

    const updatePost = ({form, id}) => {
        if(modalRef===null){
            return;
        }
        modal.openModal({
            content: '게시글을 수정하시겠습니까?',
            event: ()=>{
                form.put(route('post.update', {id: id}), {
                    onError: (errors)=>{
                        console.log(errors)
                    }
                });
            }
        })
    }

    const editPostPage = ({id}) => {
        router.get(route('post.edit', {id: id}));
    }

    const destroyPost = ({id}) => {
        if(modalRef===null){
            return;
        }
        modal.openModal({
            content: '게시글을 정말 삭제하시겠습니까?',
            event: ()=>{
                router.delete(route('post.destroy', {id: id}));
            }
        })
    }

    const searchPosts = ({query})=>{
        console.log(query);
        if(!query){
            return;
        }
        const data = {data: {query: query}};
        router.visit(route('posts.index'), data);
    }

    return {
        showPost,
        storePost,
        updatePost,
        editPostPage,
        destroyPost,
        searchPosts
    };
}
