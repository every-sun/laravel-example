<template>
    <button class="rounded-md text-white px-2 py-1 bg-third hover:bg-neutral" :class="size?size:'text-sm'" @click="$emit('event')">
        {{ props.title }}
    </button>
</template>
<script setup>
const props = defineProps({
    title: String,
    size: String || null || undefined
})
defineEmits(['event'])
</script>
