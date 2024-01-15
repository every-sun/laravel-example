<template>
    <TransitionRoot as="template" :show="urls.length>0" id="modal">
        <Dialog as="div" class="relative z-10" @close="emits('onClose')">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-2 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6 flex justify-center items-center gap-3">
                            <button class="hover:text-neutral" @click="setCurrentIdx(false)" v-if="urls.length>1">
                                <ChevronLeftIcon class="w-7" />
                            </button>
                            <img :src="`/storage/${urls[currentIdx]}`" alt="이미지" class="h-full object-cover" :class="urls.length>1?'w-[90%]':'w-full'">
                            <button class="hover:text-neutral" @click="setCurrentIdx(true)" v-if="urls.length>1">
                                <ChevronRightIcon class="w-7" />
                            </button>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
<script setup>
    import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from "@headlessui/vue";
    import { ChevronLeftIcon, ChevronRightIcon } from "@heroicons/vue/24/outline/index.js";
    import { ref } from "vue";

    const props = defineProps({
        urls: Array
    })
    const emits = defineEmits(['onClose']);

    const currentIdx = ref(0);
    const setCurrentIdx = (isNext) => {
        if ( isNext ){
            if(!(currentIdx.value >= props.urls.length-1)){
                currentIdx.value++;
            }
        }else{
            if(currentIdx.value>=1){
                currentIdx.value--;
            }
        }
    }
</script>
