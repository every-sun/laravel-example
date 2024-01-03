<template>
    <p class="text-xs text-indigo-500">
        {{ text }}
    </p>
</template>

<script setup>
const props = defineProps({
    text: String || null || undefined
})

</script>
