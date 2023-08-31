<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Form from '@/Pages/Posts/Form.vue';

defineProps({
 post: {
     type: Object,
 },
 created:{
        type: String,
 }
});
</script>

<template>
    <Head title="Create a Post" />

    <AuthenticatedLayout> 
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div>
                        <Form />
                    </div>
                </div>

            </div>
        </div>
   </AuthenticatedLayout>

</template>
                    