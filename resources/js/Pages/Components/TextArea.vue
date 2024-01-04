<template>
    <div>
        <textarea :rows="rows?rows:8" v-model="localValue" class="block w-full resize-none border-0 bg-transparent py-1.5 px-3 text-gray-900 placeholder:text-gray-400 focus:ring-2 sm:text-sm sm:leading-6 rounded-md shadow-sm ring-1 ring-inset ring-gray-300" :placeholder="name" />
        <ErrorText :text="error"/>
    </div>
</template>
<script setup>
import { computed } from "vue";
import ErrorText from "./ErrorText.vue";

const props = defineProps({
    modelValue: null,
    name: String,
    rows: Number || null || undefined,
    error: String || null || undefined
})
const emits = defineEmits(['update:modelValue']);
const localValue = computed({
    get: ()=>props.modelValue,
    set: value => emits('update:modelValue', value)
})
</script>
