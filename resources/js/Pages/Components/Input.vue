<template>
    <div class="w-full">
        <input :type="type?type:'text'" v-model="localValue" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" :placeholder="name" />
        <ErrorText :text="error"/>
    </div>
</template>
<script setup>
import { computed } from "vue";
import ErrorText from "./ErrorText.vue";

const props = defineProps({
    modelValue: null,
    type: String || null || undefined,
    name: String,
    error: String || null || undefined
});
const emits = defineEmits( [ "update:modelValue" ] );
const localValue = computed({
    get: () => props.modelValue,
    set: value => emits('update:modelValue', value)
})
</script>
