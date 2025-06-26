<template>
  <div class="p-6 text-center">
      <Header/>
      <router-view />

  </div>
</template>

<script setup>
import { ref } from 'vue';
import Header from "@/entrypoints/components/Header.vue";
const count = ref(0);
</script>
