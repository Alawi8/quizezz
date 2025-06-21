<template>
  <div class="p-6 text-center">
      <Header/>
      <router-view />

  </div>
</template>

<script setup>
import { ref } from 'vue';
import home from './components/Home.vue';
import Header from "@/entrypoints/components/Header.vue";
const count = ref(0);
</script>
