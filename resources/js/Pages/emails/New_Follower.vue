<template>
    <div class="bg-white border rounded-lg shadow-md w-full max-w-md mx-auto my-4 p-6">
      <header class="flex items-center justify-between mb-4">
        <span class="text-gray-700 font-semibold">New Notification</span>
        <span class="text-sm text-gray-500">Just now</span>
      </header>
      <div class="email-content">
        <h1 class="text-lg font-semibold mb-2">{{ subject }}</h1>
        <p class="text-gray-700">
          Congratulations! You have gained a new follower on our platform.
        </p>
        <p class="text-gray-700 mt-4">
          Click <a href="#" class="text-blue-500 underline">here</a> to check out your updated profile.
        </p>
      </div>
      <footer class="mt-4">
        <button class="text-blue-500 hover:underline">View Profile</button>
      </footer>
    </div>
  </template>
  
  <script setup>
  import { defineProps } from 'vue';
  
  const { subject } = defineProps(['subject']);
  </script>
  
  <style scoped>
  /* You can add additional styles here if needed */
  </style>