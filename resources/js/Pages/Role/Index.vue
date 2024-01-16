<template>
    <Layout :title="'User Role'">
        <div class="w-full flex flex-col h-full justify-between items-center">
            <form class="flex w-full gap-6 items-center justify-center border-b-2 pb-2" @submit.prevent="storeRole({form})">
                <h1 class="font-semibold text-neutral">User role</h1>
                <div class="flex gap-4 w-[40%] items-end">
                    <div class="flex-col flex w-48">
                        <select id="priority" v-model="form.priority" name="priority" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            <option disabled class="hidden">등급</option>
                            <option>{{ 1 }}</option>
                            <option>{{ 2 }}</option>
                            <option>{{ 3 }}</option>
                        </select>
                    </div>
                    <Input name="유형" v-model="form.name"/>
                </div>
                <Button title="등록" />
            </form>
            <h1 class="font-semibold text-neutral">User</h1>
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
                <tbody class="bg-white" v-if="userData.total===0">
                <tr>
                    <td colspan="4" class="p-4 h-96 text-sm text-center text-gray-400">
                        회원이 존재하지 않습니다.
                    </td>
                </tr>
                </tbody>
                <tbody v-else class="divide-y divide-gray-200 bg-white">
                <UserTableItem v-for="user in userData.data" :key="user.id" :user="user" :roles="roleData" />
                </tbody>
            </table>
            <PaginationButtons :links="userData.links" />
            <Modal ref="modalRef"/>
        </div>
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
import PaginationButtons from "@/Pages/Components/PaginationButtons.vue";

const props = defineProps({
    roleData: Object,
    userData: Object
})
const modalRef = ref(null)
const {storeRole} = useRole({modalRef});
const form = useForm(
    {
        name: null,
        priority: '등급'
    }
)

</script>
