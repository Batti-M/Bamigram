<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import PostLayout from '@/Pages/Posts/PostLayout.vue';
import { onMounted , ref } from 'vue';


defineProps({
 post: {
     type: Object,
 },
 created:{
        type: String,
 },
comments: {
    type: Array,
},

});
const page = usePage()
const allComments = ref(page.props.comments)

    onMounted(() => {
        Echo.private(`post.${page.props.post.id}`).listen('App\Events\CommentEvent', e => {
            console.log('data', e.comment)
            allComments.value.push(e.comment)
        })
    })
</script>

<template>
    <Head title="Home" />

   <AuthenticatedLayout> 
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Timeline</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">Hi,   {{ $page.props.auth.user.name }}!?</div>
                    <p class="p-6 text-gray-900 dark:text-gray-100">Here is your post!</p>
                  
                            <PostLayout :post="post" :created="created" :allComments="allComments" />
                    
                </div>
            </div>
        </div>
   </AuthenticatedLayout>
</template>

<style>

</style>
