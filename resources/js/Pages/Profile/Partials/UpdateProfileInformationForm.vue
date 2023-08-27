<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
    username: user.username,
});

const imageForm = useForm({
    profile_photo_url: user.profile_photo_url,
})

function uploadImage(e) {
    imageForm.profile_photo_url = e.target.files[0];
    user.profile_photo_url = e.target.files[0]

};

function updateProfile() {
    form.patch(route('profile.update'), {  
    });
}

function updateProfileImage() {
    imageForm.post(route('profile.store'), {
        preserveScroll: true,
        onSuccess: () => {
           imageForm.clear();
        },
    });
}
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Profile Information</h2>
            
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Update your account's profile information and email address.
            </p>
        </header>
        <img v-if="user.profile_photo_url" :src="user.profile_photo_url" alt="profile image" class="w-20 h-20 rounded-full object-cover">
        <form @submit.prevent="updateProfileImage">
            <div class="text-gray-200">
                <label for="profile_photo_url">Image</label>
                <input type="file" @input="uploadImage" id="profile_photo_url" name="profile_photo_url" class="border border-gray-200 rounded px-2 py-1">
                <button type="submit" class="bg-blue-500 px-4 py-2 rounded ml-4 hover:bg-blue-700">Upload</button>
            </div>
        </form>
        <form @submit.prevent="updateProfile" class="mt-6 space-y-6" enctype="multipart/form-data">
            
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>
            <div>
                <InputLabel for="username" value="Username" />

                <TextInput
                    id="username"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.username"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.username" />
            </div>

            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 font-medium text-sm text-green-600 dark:text-green-400"
                >
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
