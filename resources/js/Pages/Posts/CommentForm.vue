<template>
    <form @submit.prevent="sendComment" class="flex flex-col">
        <textarea v-model="form.content" placeholder="Leave a comment"
            class="text-gray-900 order border-gray-200 rounded-lg p-2 mt-2" required></textarea>

        <button class="bg-blue-500 text-white rounded-lg p-2 mt-2">Submit</button>
    </form>
</template>


<script setup>
import { useForm, usePage } from '@inertiajs/vue3';

const form = useForm({
    content: '',
})
const page = usePage()

const sendComment = async () => {
    form.post(`/posts/${page.props.post.id}/comments`, {
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
        }
    })
}

</script>

<style lang="scss" scoped></style>