<script setup lang="ts">

type Props = {
    variant?: 'left' | 'right';
    class?: string;
};

const props = defineProps<Props>();

</script>

<template>
    <div :class="variant + '-0'" class="w-64 absolute top-0 w-1/2 h-full bg-gray-800 text-white z-30 transform transition">
        <div class="h-16 border-b border-sidebar-border/70 dark:border-sidebar-border p-4">
            <h2 class="text-lg font-semibold">My Manga Shelf</h2>
            <button @click="$emit('close');">close</button>
        </div>
        <div class="p-4">
            <p>Sidebar content goes here</p>
        </div>
    </div>
</template>
