<template>
    <div class="flex flex-col items-end bg-gradient-to-r from-transparent to-gray-900 text-gray-300 p-4 rounded-3xl shadow-sm shadow-gray-400 m-4 gap-2 w-2/3" >
        <div class=" mb-2 max-w-3/4 flex justify-end">
            <p class=""> {{ comment.content }}</p>
        </div>
        <hr>
        <div class="underline flex justify-end">
           <!-- <small> {{ comment.user.name }}  - {{ comment.created_at }}</small>  -->
        </div>
    </div>
</template>


<script setup>


defineProps({
    comment: {
        type: Object,
    }
})

</script>

<style lang="scss" scoped>

</style>