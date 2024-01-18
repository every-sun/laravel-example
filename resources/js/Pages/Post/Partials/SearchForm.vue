<template>
    <div class="flex w-full gap-4">
        <Input v-model="query" />
        <Button title="검색" @event="onSearch">
            <template v-slot:icon>
                <MagnifyingGlassIcon class="w-4"/>
            </template>
        </Button>
    </div>
</template>
<script setup>
import Button from "@/Pages/Components/Button.vue";
import Input from "@/Pages/Components/Input.vue";
import { MagnifyingGlassIcon } from "@heroicons/vue/24/outline/index.js";
import { ref } from "vue";
import usePost from "@/libs/controller/usePost.js";

const query = ref(null);
const {searchPosts} = usePost({modalRef: null});
const onSearch = () => {
    searchPosts({query: query.value})
}


</script>
