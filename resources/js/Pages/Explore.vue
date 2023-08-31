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
    <Head title="Explore" />

    <AuthenticatedLayout>

        <div class="py-12 bg-gray-800 mt-4 ">
            <div v-for="post in posts" :key="post.id">
                <PostImage :post="post" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
