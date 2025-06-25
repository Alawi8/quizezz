<script setup lang="ts">
import { BarChart2, FileText, FolderOpen, Settings } from "lucide-vue-next";
import { RouterLink, useRoute } from "vue-router";
import { computed } from "vue";

const route = useRoute();
const testId = computed(() => route.params.test_id as string | undefined);
</script>

<template>
    <nav class="flex items-center justify-center gap-6 py-2 border-b border-white/10 text-sm font-medium">
        <!-- Results -->
        <template v-if="testId">
            <RouterLink
                :to="{ name: 'quiz', params: { test_id: testId.value } }"
                class="flex items-center gap-1 hover:text-green-400 transition duration-200"
            >
                <FileText class="w-4 h-4" /> Questions
            </RouterLink>
            <RouterLink
                :to="{ name: 'Result', params: { test_id: testId.value } }"
                class="flex items-center gap-1 hover:text-green-400 transition duration-200"
            >
                <BarChart2 class="w-4 h-4" /> Results
            </RouterLink>
            <RouterLink
                :to="{ name: 'Review', params: { test_id: testId.value } }"
                class="flex items-center gap-1 hover:text-green-400 transition duration-200"
            >
                <FolderOpen class="w-4 h-4" /> Review
            </RouterLink>
        </template>

        <template v-else>
      <span class="flex items-center gap-1 text-gray-400 cursor-not-allowed">
        <FileText class="w-4 h-4" /> Questions
      </span>
            <span class="flex items-center gap-1 text-gray-400 cursor-not-allowed">
        <BarChart2 class="w-4 h-4" /> Results
      </span>
        </template>

        <!-- Settings -->
        <button class="flex items-center gap-1 hover:text-green-400 transition duration-200">
            <Settings class="w-4 h-4" /> Settings
        </button>
    </nav>
</template>

<style scoped>
</style>
