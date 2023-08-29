<template>
  <div class="relative border border-red-200 rounded-xl text-gray-200 aspect-square">
    <Link :href="route('posts.show', post)">

    <img :src="post.img_url" alt="post.description" class="h-full w-full object-cover rounded-lg shadow-md " />
   
    </Link>
</div>

</template>

<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({
    post: {
        type: Object,
    },
});


</script>

<style lang="scss" scoped>

</style>