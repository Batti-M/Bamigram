<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import UpdateForm from '@/Pages/Posts/UpdateForm.vue';

defineProps({
 post: {
     type: Object,
 }
 
});
</script>

<template>
    <Head title="Edit a Post" />

   <AuthenticatedLayout> 
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Timeline</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">Hi,   {{ $page.props.auth.user.name }}!?</div>
                    <p class="p-6 text-gray-900 dark:text-gray-100">Here is your post!</p>
                    <div>

                        <UpdateForm :post="post"/>

                    </div>
                    
                </div>
            </div>
        </div>
   </AuthenticatedLayout>
</template>

<style>

</style>
