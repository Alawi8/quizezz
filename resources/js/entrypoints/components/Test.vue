<template>
  <div class="space-y-2 p-4">
    <h2 class="text-xl font-bold">👨 Info</h2>
    <p>Name: {{ man.name }}</p>
    <p>Nationality: {{ man.nationality }}</p>
    <p>Age: {{ man.age }}</p>
    <p>Energy: {{ man.energy }}</p>

    <button @click="man.birthday()" class="bg-blue-500 text-white px-3 py-1 rounded">
      🎂 Birthday
    </button>
    <button @click="man.work()" class="bg-red-500 text-white px-3 py-1 rounded">
      💼 Work
    </button>
  </div>
</template>

<script setup>
import { reactive } from 'vue'

class Man {
  constructor(name, nationality) {
    this.name = name
    this.nationality = nationality
    this.age = 30
    this.energy = 100
  }

  birthday() {
    this.age++
  }

  work() {
    if (this.energy > 0) this.energy -= 10
  }
}

const man = reactive(new Man('Ayoub', 'Saudi'))
</script>
