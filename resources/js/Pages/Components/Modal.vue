<template>
    <TransitionRoot as="template" :show="open" id="modal">
        <Dialog as="div" class="relative z-10" @close="open = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                            <div class="sm:flex sm:items-start flex gap-3">
                                <QuestionMarkCircleIcon class="h-6 w-6 text-yellow-400" aria-hidden="true" />
                                <p class="text-third">
                                    {{ content }}
                                </p>
                            </div>
                            <div class="mt-4 flex gap-1 justify-end">
                                <Button @event="clickAgree" title="확인" />
                                <button type="button" class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:w-auto" @click="open = false" ref="cancelButtonRef">취소</button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
<script setup>
import { ref } from 'vue'
import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { QuestionMarkCircleIcon } from '@heroicons/vue/24/outline'
import Button from "./Button.vue";

const props = defineProps({
    title: String || null || undefined,
})


const open = ref(false)
const content = ref('실행하시겠습니까?')
const event = ref(null);
const clickAgree = () => {
    open.value = false;
    event.value();
}

defineExpose({
    open, content, event
})

</script>
