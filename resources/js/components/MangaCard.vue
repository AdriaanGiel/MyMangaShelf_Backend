<script setup lang="ts">
import { ref } from 'vue';

const active = ref(false);

const props = defineProps<{
    title: string;
    coverUrl: string;
    mode: 'small' | 'medium' | 'large';
}>();


function toggleActive() {
    active.value = !active.value;
    console.log('toggle active', active.value);
}
</script>

<template>
    <a @click.prevent="toggleActive"  rel="stylesheet" class="manga-card " href="">
       <div class="relative shadow-xl overflow-hidden">
            <img :src="coverUrl" alt="Manga Cover" :class="active ? 'active' : ''" class="manga-image rounded-lg  object-cover w-48 h-48" />
            <div class="absolute bg-black opacity-30 w-full  h-full top-0"></div>
            <div v-if="title" class="absolute top-0 left-0 right-0  text-white text-2xl font-bold p-2 rounded-b-lg">
                {{ title }}
            </div>
        </div>
    </a>


</template>

<style scoped>
.manga-image {
    aspect-ratio: 1;
    object-fit: cover;
}

.active {
    transform: scale(1.2);
    transition: transform 0.3s ease;
}
</style>
