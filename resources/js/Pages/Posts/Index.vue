<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import PostImage from '@/Pages/Posts/PostImage.vue';

defineProps({
    posts: {
        type: Array,
    },
});



</script>

<template>
    <Head title="All Posts" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-400 leading-tight">Timeline</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-200">Hi, {{ $page.props.auth.user.name }}!?</div>
                    <p class="p-6 text-gray-900 dark:text-gray-100">Here is some new Content for you!</p>
                    <div class="grid grid-cols-3 gap-4 "> 
                        <div v-for="post in posts" :key="post.id" > 
                            <PostImage :post="post"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
