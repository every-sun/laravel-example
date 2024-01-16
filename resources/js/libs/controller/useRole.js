import {router} from '@inertiajs/vue3';
import { inject } from "vue";
import useModal from "../useModal.js";
export default function useRole({modalRef}){
    const route = inject('route');
    const modal = useModal({modalRef});
    const storeRole = ({form}) => {
        if(form.data().priority==='등급'){
            return;
        }
        modal.openModal({
            content: '새로운 role을 등록하시겠습니까?',
            event: ()=>{
                form.post(route('role.store'), {
                    preserveScroll: true,
                    onSuccess: () => form.reset(),
                    onError: (errors)=>{
                        console.log(errors.content)
                    }
                });
            }
        })
    }

    const updateUserRole = ({user_id, role_id})=>{
        modal.openModal({
            content: '등록된 role을 수정하시겠습니까?',
            event: ()=>{
                router.put(route('user.role.update', {user_id, role_id}), {
                    preserveScroll: true,
                    onSuccess: () => form.reset(),
                    onError: (errors)=>{
                        console.log(errors.content)
                    }
                });
            }
        })
    }

    return {
        storeRole,
        updateUserRole
    };
}
