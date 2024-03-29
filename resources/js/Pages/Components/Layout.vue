<template>
    <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
        <div class="flex grow flex-col gap-y-2 overflow-y-auto bg-secondary px-6 pb-4">
            <div class="flex h-16 shrink-0 items-center justify-between">
                <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=white" alt="Your Company" />
                <TextButton title="" @event="login" v-if="$page.props.auth.user===null">
                    <template v-slot:suffix-icon><ArrowLeftStartOnRectangleIcon class="w-5 hover:w-6"/></template>
                </TextButton>

            </div>
            <div class="mb-6 flex justify-between items-start" v-if="$page.props.auth.user!==null">
                <div>
                    <p>{{ $page.props.auth.user.name }} 님</p>
                    <p class="text-xs text-neutral">{{ $page.props.auth.user.email }}</p>
                </div>
                <TextButton title="" @event="logout">
                    <template v-slot:suffix-icon><ArrowRightStartOnRectangleIcon class="w-5 hover:w-6" /></template>
                </TextButton>
            </div>
            <nav class="flex flex-1 flex-col">
                <h3 class="text-white font-semibold mb-3">메인</h3>
                <ul role="list" class="-mx-2">
                    <li v-for="item in mainNavigation" :key="item.name">
                        <a :href="item.href" :class="[item.current ? 'text-third' : 'text-neutral hover:text-third', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                            <component :is="item.icon" :class="[item.current ? 'text-third' : 'text-neutral group-hover:text-third', 'h-6 w-6 shrink-0']" aria-hidden="true" />
                            {{ item.name }}
                        </a>
                    </li>
                </ul>
                <hr class="my-6"/>
                <h3 class="text-white font-semibold mb-4">사용자</h3>
                <ul role="list" class="-mx-2 mb-3">
                    <li v-for="item in userNavigation" :key="item.name">
                        <a :href="item.href" :class="[item.current ? 'text-third' : 'text-neutral hover:text-third', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                            <component :is="item.icon" :class="[item.current ? 'text-third' : 'text-neutral group-hover:text-third', 'h-6 w-6 shrink-0']" aria-hidden="true" />
                            {{ item.name }}
                        </a>
                    </li>
                </ul>
                <hr class="my-6"/>
                <h3 class="text-white font-semibold mb-4">기타</h3>
                <ul role="list" class="-mx-2 mb-3">
                    <li v-for="item in temporaryNavigation" :key="item.name">
                        <a :href="item.href" :class="[item.current ? 'text-third' : 'text-neutral hover:text-third', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                            <component :is="item.icon" :class="[item.current ? 'text-third' : 'text-neutral group-hover:text-third', 'h-6 w-6 shrink-0']" aria-hidden="true" />
                            {{ item.name }}
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="lg:pl-72 h-screen">
        <div class="sticky top-0 z-40 flex h-[8%] shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
            <p>{{ title }}</p>
        </div>
        <main class="py-10 h-[92%] p-4">
            <slot></slot>
        </main>
    </div>
    <Modal ref="modalRef"/>
</template>
<script setup>
import {
    FolderIcon,
    PhotoIcon,
    PencilIcon,
    Bars3Icon,
    ArrowLeftStartOnRectangleIcon,
    ArrowRightStartOnRectangleIcon,
    ChatBubbleLeftIcon,
    CameraIcon,
    HandThumbUpIcon,
} from '@heroicons/vue/24/outline'
import {EyeIcon, HeartIcon} from "@heroicons/vue/16/solid/index.js";
import { inject, ref } from "vue";
import { router } from "@inertiajs/vue3";
import TextButton from "@/Pages/Components/TextButton.vue";
import Modal from "@/Pages/Components/Modal.vue";
import useModal from "@/libs/useModal.js";

const props = defineProps(
    {
        title: String || null || undefined,
        modalRef: ref || null || undefined,
    }
)

const route = inject('route')
const modalRef = ref(null);

const {openModal} = useModal({modalRef});

const mainNavigation = [
    { name: '목록', href: route('posts.index'), icon: Bars3Icon, current: route().current('posts.index'), },
    { name: '최근 조회된 게시물', href: route('posts.history.index'), icon: EyeIcon, current: route().current('posts.history.index') },
]


const userNavigation = [
    { name: '작성', href: route('post.create'), icon: PencilIcon, current: route().current('post.create') },
    { name: '내 게시글', href: route('user.posts.index'), icon: FolderIcon, current: route().current('user.posts.index') },
    { name: '내 댓글', href: route('user.comments.index'), icon: ChatBubbleLeftIcon, current: route().current('user.comments.index') },
    { name: '좋아한 댓글', href: route('user.comments.likes.index'), icon: HeartIcon, current: route().current('user.comments.likes.index') },
]

const temporaryNavigation = [
    { name: '앨범', href: route('files.index'), icon: PhotoIcon, current: route().current('files.index'), },
    { name: '업로드', href: route('files.create'), icon: CameraIcon, current: route().current('files.create'), },
    { name: 'User Role', href: route('roles.index'), icon: HandThumbUpIcon, current: route().current('roles.index') },
]

const logout = () => {
    openModal({content: '로그아웃 하시겠습니까?', event: ()=>{
        router.post(route('logout'));
    }});
};

const login = () => {
    router.get(route('login'));
}


</script>
