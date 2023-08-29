<template>
    <hr class="mx-8">
    <form  @submit.prevent="submit" class="space-y-4 max-w-md m-auto mt-8">
        <div class="flex flex-col space-y-4 text-gray-200">
            <img :src="post.img_url" />
            <div class="flex flex-col  ">
                <label for="body">Message</label>
                <input v-model="form.body" type="text" id="body" name="body" placeholder="Create a post..."
                    class="border border-gray-300 text-gray-900 rounded px-2 py-1">
                <div v-if="router.page.props.errors.body" class="text-red-500 text-sm">
                    {{ router.page.props.errors.body }}
                </div>
            </div>

            <div class="flex flex-col">
                <label for="img_url">Image</label>
                <input type="file" @input="uploadImage" id="imgUrl" name="img_url" class="border border-gray-200 rounded px-2 py-1" >
                <input type="text" name="description" placeholder="describe your picture" class="border border-gray-200 rounded px-2 py-1 mt-2 text-gray-900" >
                <div v-if="router.page.props.errors.img_url" class="text-red-500 text-sm">
                    {{ router.page.props.errors.img_url }}
                </div>
            </div>

        </div>

        
        <div class="flex ">

            <button :disabled="form.processing" class="text-black rounded px-4 py-2 my-4"
                :class="{ 'bg-blue-500 text-white': !form.processing, 'bg-grey-300': form.processing }">Create</button>
                
        </div>

    </form>
</template>

<script setup>

import { useForm, router } from '@inertiajs/vue3';


const { post } = defineProps({
    post: {
        type: Object,
       default: () => ({})
    }
});


const form = useForm({
    img_url: post.img_url || '',
    body: post.body || '',
});

function submit() { 

        form.post('/posts');

}

function uploadImage(e) {
    form.img_url = e.target.files[0];
};


</script>

<style lang="scss" scoped></style>