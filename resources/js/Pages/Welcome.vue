<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },

});
</script>

<template>
    <GuestLayout>

        <Head title="Welcome" />


        <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-right w-full flex justify-between">
            
                <Link href="/">
                    <ApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
                </Link>

                <div>
                      <Link v-if="$page.props.auth.user" :href="route('explore')"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
            Explore</Link>

            <template v-else>
                <Link :href="route('login')"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                Log in</Link>

                <Link v-if="canRegister" :href="route('register')"
                    class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                Register</Link>
            </template>
                </div>
          
        </div>

        
        <div class="mt-3 text-gray-200 text-center p-4">
            <p> Willkommen in meinem finalen Projekt!</p>
            <p> Ich habe mich entschieden daraus eine SPA mit Hilfe von Inertia zu machen...</p>
            <p> Zudem benutze ich Laravel Breeze und Sozialite </p>
            <p> Für nen fixen start registrieren Sie hier sich mit  <a class="text-blue-500" href="/auth/redirect">github </a></p>
        </div>




    </GuestLayout>
</template>

