<template>
    <button class="flex items-center hover:font-semibold" :class="size?size:'text-sm'" @click="$emit('event')">
        <slot name="icon"></slot>
        {{ props.title }}
        <slot name="suffix-icon"></slot>
    </button>
</template>
<script setup>
const props = defineProps({
    title: String,
    size: String || null || undefined
})
defineEmits(['event'])
</script>
