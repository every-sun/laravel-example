<template>
    <button class="flex items-center" :class="size?size:'text-sm'" @click="$emit('event')">
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
