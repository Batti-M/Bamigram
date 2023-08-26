<template>
    <div class=" border border-red-200 rounded-xl text-gray-200 w-3/4 h-full flex items-start">


        <img :src="post.img_url" alt="post image"
            class=" object-cover object-center rounded-lg shadow-md w-1/2 aspect-square" />

        <div class="flex flex-col p-4">
            <small> {{ created }}</small>
            <p class="underline mb-4"> {{ post.author.name }}</p>
            <p class="mb-4">you got {{ author.followers.length }} Follower(s)</p>

            <form v-if="!isFollower" @submit.prevent="follow" method="post">
                <button class="bg-purple-700 text-white rounded-lg p-2 px-4 mt-2">Follow</button>
            </form>
            <form v-if="isFollower" @submit.prevent="unfollow" method="post">
                <button class="bg-purple-700 text-white rounded-lg p-2 px-4 mt-2">Unfollow</button>
            </form>

            <p>{{ post.body }}</p>

            <i class="fa-solid fa-heart text-3xl" :class="{ 'text-grey-200': !like, 'text-red-500': like }"
                @click.prevent="toggleLike()"></i>

            <i class="fa-solid fa-comment-dots text-3xl" @click="toggleShowComments"></i><small class="text-xs"> {{
                currentUser.name }},Leave a comment</small>


            <NavLink :href="`/posts/${post.id}/edit`" class="bg-blue-500 text-white rounded-lg p-2 mt-2">edit
                Post
            </NavLink>

            <button v-if="$page.props.auth.user.id === post.author.id"
                class="bg-red-400 text-white rounded-lg p-2 mt-2">Delete</button>
            <button v-if="$page.props.auth.user.id === post.author.id"
                class="bg-blue-500 text-white rounded-lg p-2 mt-2">Edit</button>
            <div v-if="createComment" class="flex flex-col">

                <CommentForm />
            </div>
            <ul class="flex justify-end flex-col">
                <Comment v-for="comment in allComments" :key="comment.id" :comment="comment" />
            </ul>

        </div>
    </div>
</template>
  
<script setup>
import { ref, computed } from 'vue'
import { router, usePage, useForm } from '@inertiajs/vue3'
import NavLink from '@/Components/NavLink.vue';
import CommentForm from '@/Pages/Posts/CommentForm.vue';
import Comment from '@/Pages/Posts/Comment.vue';


defineProps({
    post: {
        type: Object,
    },
    created: {
        type: String,
    },
    allComments: {
        type: Array,
    },
});

const form = useForm({
    body: '',
})
const page = usePage()
const currentUser = computed(() => page.props.auth.user)

let createComment = ref(false)

let like = computed(() => page.props.post.liked_by.some((user) => user.id === currentUser.value.id))
let isFollower = computed(() => page.props.followers.some((follower) => follower.id === currentUser.value.id))
const author = computed(() => page.props.post.author)


function toggleLike() {
    if (like.value === false) {
        router.post(`/like/${page.props.post.id}`, {
            like: true
        });
    } else {
        router.delete(`/unlike/${page.props.post.id}`, {
            like: false
        });
    }
}

function toggleShowComments() {
    createComment.value = !createComment.value;
}


function follow() {
    router.post(`/follow/${author.value.id}`, {
        author: page.props.post.author,
        follow: true
    });
}
function unfollow() {
    router.delete(`/unfollow/${author.value.id}`);
}

</script>
  
<style lang="scss" scoped></style>