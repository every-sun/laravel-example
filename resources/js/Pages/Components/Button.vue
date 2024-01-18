<template>
    <button class="shrink-0 rounded-md text-white px-2 py-1 bg-third hover:bg-neutral flex items-center justify-center gap-2" :class="size?size:'text-sm'" @click="$emit('event')">
        <slot name="icon"></slot>
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
