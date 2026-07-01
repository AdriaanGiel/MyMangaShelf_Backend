<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import FrontAppLayout from '@/layouts/FrontAppLayout.vue';
import MangaShelf from '../components/MangaShelf.vue';

</script>

<template>
    <Head title="My Shelf" />

    <FrontAppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My Shelf
            </h2>
        </template>
        <div class="px-2">
        <MangaShelf />
        </div>
    </FrontAppLayout>
</template>
