<template>
    <div class="flex gap-0.5">
        <template v-for="(item, i) in props.links" :key="item.label">
            <Link v-if="item.url" :href="item.url" :class="[(route().params.page===item.label || (!route().params.page && item.label==='1'))?'bg-neutral':'bg-third'] " class="rounded-md text-white px-2 py-1 hover:bg-neutral">
                {{ i===0?'이전':(i===props.links.length-1?'다음':item.label) }}
            </Link>
            <button v-else class="rounded-md px-2 py-1 bg-gray-200 text-gray-500 cursor-auto">
                {{ i===0?'이전':(i===props.links.length-1?'다음':item.label) }}
            </button>
        </template>
    </div>
</template>
<script setup>
import { inject } from "vue";
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    links: Array
})

const route = inject('route')
</script>
