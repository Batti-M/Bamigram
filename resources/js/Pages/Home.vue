<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
    users: {
        type: Object,
    },
});

const search = ref('');

watch(search, (value) => {
    router.get('/home', { search: value }, { preserveState: true });
});
</script>

<template>
    <Head title="Home" />

   <AuthenticatedLayout> 
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Home</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex justify-evenly items-center text-center ">
                    <div class="p-6 text-gray-900 dark:text-gray-100">What's up,   {{ $page.props.auth.user.name }}!?</div>
                  
                    <!-- <i class="fa-solid fa-magnifying-glass" style="color: #d5d8dc;"></i> -->
                    
                        <Link href="/posts" class="text-gray-900 dark:text-gray-100  mx-8 flex flex-col items-center">
                            <i class="fa-solid fa-magnifying-glass text-3xl" style="color: #d5d8dc;"> 
                            </i>
                                <small class="text-xs">Search for posts</small>
                        </Link>
                        <input v-model="search" type="text" class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none" placeholder="Search for a user">

                        <Link href="/posts/create" class="text-gray-900 dark:text-gray-100 flex flex-col pr-4">
                            <i class="fa-sharp fa-solid fa-pen text-3xl " style="color: #d8dee9;"> 
                            </i>
                                <small class="text-xs">Create a new post</small>
                        </Link>
                    </div>
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <ul v-if="search">
                            <li v-for="user in $page.props.users.data" :key="user.id">
                                <Link>
                                    {{ user.name }}
                                </Link>
                            </li>
                        </ul>
                    </div>
                    

            </div>
        </div>
   </AuthenticatedLayout>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
