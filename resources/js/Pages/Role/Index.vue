<template>
    <Layout :title="'User Role'">
        <div>
            <h1 class="font-semibold text-neutral mb-1.5">추가</h1>
            <form class="flex w-full gap-6 items-end" @submit.prevent="storeRole({form})">
                <div class="flex gap-4 w-[40%] items-end">
                    <div class="flex-col flex w-48">
                        <label for="priority"  class="block text-sm font-medium leading-6 text-gray-900">중요도</label>
                        <select id="priority" v-model="form.priority" name="priority" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            <option>{{ 1 }}</option>
                            <option>{{ 2 }}</option>
                            <option>{{ 3 }}</option>
                        </select>
                    </div>
                    <Input name="유형" v-model="form.name"/>
                </div>
                <Button title="등록" />
            </form>
        </div>
        <hr class="my-3"/>
        <h1 class="font-semibold text-neutral mb-1.5">회원</h1>
        <table class="w-full divide-y divide-gray-300 border-2 justify-center ">
            <thead>
            <tr class="w-full">
                <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900 w-[5%] ">id</th>
                <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900 w-[20%]">이름</th>
                <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900 w-[20%]">가입일</th>
                <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900 w-[35%]">role</th>
                <th scope="col" class="px-3 py-1 text-left text-sm font-semibold text-gray-900 w-[20%]">추가/제거</th>
            </tr>
            </thead>
            <tbody class="bg-white" v-if="users.length===0">
            <tr>
                <td colspan="4" class="p-4 h-96 text-sm text-center text-gray-400">
                    회원이 존재하지 않습니다.
                </td>
            </tr>
            </tbody>
            <tbody v-else class="divide-y divide-gray-200 bg-white">
            <UserTableItem v-for="user in users" :key="user.id" :user="user" :roles="data" />
            </tbody>
        </table>
        <Modal ref="modalRef"/>
    </Layout>
</template>
<script setup>
import Layout from "@/Pages/Components/Layout.vue";
import Input from "@/Pages/Components/Input.vue";
import Button from "@/Pages/Components/Button.vue";
import Modal from "@/Pages/Components/Modal.vue";
import { ref } from "vue";
import useRole from "@/libs/controller/useRole.js";
import { useForm } from "@inertiajs/vue3";
import UserTableItem from "@/Pages/Role/Partials/UserTableItem.vue";

const props = defineProps({
    data: Object,
    users: Object
})
const modalRef = ref(null)
const {storeRole} = useRole({modalRef});
const form = useForm(
    {
        name: null,
        priority: 1
    }
)

console.log(props.data);
console.log(props.users);
</script>
