<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import PostImage from '@/Pages/Posts/PostImage.vue';
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'

defineProps({
    ownPosts: {
        type: Object,
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

        <div class="pb-4 mt-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex justify-evenly items-center text-center p-2 ">

                    <Link href="/posts" class="text-gray-100  mx-8 flex flex-col items-center">
                    <i class="fa-solid fa-magnifying-glass text-3xl" style="color: #d5d8dc;">
                    </i>
                    <small class="text-xs">Look for other posts...</small>
                    </Link>
                    <input v-model="search" type="text"
                        class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none"
                        placeholder="Search for a user">

                    <Link href="/posts/create" class="text-gray-900 dark:text-gray-100 flex flex-col pr-4">
                    <i class="fa-sharp fa-solid fa-pen text-3xl " style="color: #d8dee9;">
                    </i>
                    <small class="text-xs">Create a new post</small>
                    </Link>
                </div>

                <div class="bg-gray-800 my-4 p-2">
                    <carousel :items-to-show="4.5">
                        <slide v-for="follower in $page.props.auth.user.following" :key="follower.id">
                            <div class="flex flex-col ">
                                <Link :href="route(`/${follower.username}`)">
                                    <img class="carousel__item" :src="follower.profile_photo_url">
                                    <small class="text-xs text-gray-200 mt-2">{{ follower.username }}</small>
                                </Link>
                            </div>
                        </slide>

                        <template #addons>
                            <navigation />
                            <pagination />
                        </template>
                    </carousel>
                </div>


                <div v-if="search" class="p-6 text-gray-900 dark:text-gray-100 bg-gray-800 rounded-xl mt-3">
                    <ul>
                        <li v-for="user in $page.props.users.data" :key="user.id">
                            <Link>
                            {{ user.username }}
                            </Link>
                        </li>
                    </ul>
                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100 bg-gray-800 rounded-xl mt-3">
                    <div class="grid lg:grid-cols-3 sm:grid-cols-2 gap-4 ">
                        <img :src="$page.props.auth.user.profile_photo_url" alt="profile picture"
                            class="h-20 w-20 rounded-full object-cover shadow-md mx-auto">
                        <div class="flex flex-col items-center">
                            <p class="text-gray-400 text-xl underline">{{ $page.props.auth.user.username }}</p>
                            <p class="text-gray-400 text-sm">check your {{ ownPosts.data.length }} posts</p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">You have {{ $page.props.auth.user.followers.length }} Follower
                            </p>
                            <p class="text-gray-400 text-sm">You are following {{ $page.props.auth.user.following.length }}
                                other user(s)</p>
                        </div>

                    </div>
                </div>
                <div v-if="ownPosts" class="p-6 text-gray-900 dark:text-gray-100 bg-gray-800 rounded-xl mt-3">
                    <ul class="grid lg:grid-cols-3 sm:grid-cols-2 gap-4 ">
                        <li v-for="post in ownPosts.data" :key="post.id">

                            <PostImage :post="post" />

                        </li>
                    </ul>
                    <p v-if="ownPosts.data.length < 1"> You dont have any posts so far.</p>
                </div>


            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
.carousel__item {
    height: 100px;
    width: 100px;
    aspect-ratio: 1/1;
    font-size: 20px;
    border-radius: 50%;
}</style>
