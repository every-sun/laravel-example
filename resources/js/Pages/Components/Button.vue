<template>
    <button class="rounded-md text-white px-2 py-1 bg-third hover:bg-neutral text-sm" @click="$emit('event')">
        {{ props.title }}
    </button>
</template>
<script setup>
const props = defineProps({
    title: String
})
defineEmits(['event'])
</script>
