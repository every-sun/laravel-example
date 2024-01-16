<template>
    <tr >
        <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{ user.id }}</td>
        <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">
            {{ user.name }}</td>
        <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{ getLongTime(user.created_at) }}</td>
        <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{ user.roles.map((e)=>e.name).toString()}}</td>
        <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500 flex gap-2">
            <select id="role" name="role"
                    class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                @change="onSelectRole($event.target.value)"
            >
                <option :value="0">선택</option>
                <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.name }} | {{ role.priority }}</option>
            </select>
        </td>
    </tr>
    <Modal ref="modalRef"/>
</template>
<script setup>
import useRole from "@/libs/controller/useRole.js";
import { ref } from "vue";
import Modal from "@/Pages/Components/Modal.vue";
import useUtils from "@/libs/useUtils.js";

const props = defineProps({
    user: Object,
    roles: Object,
})
const modalRef = ref(null)
const {updateUserRole} = useRole({modalRef});
const {getLongTime} = useUtils();
const onSelectRole = (roleId) => {
    if(roleId>0){
        updateUserRole({user_id: props.user.id, role_id: roleId})
    }
}

</script>
