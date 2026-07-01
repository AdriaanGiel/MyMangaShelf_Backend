<script setup lang="ts">
import FrontAppSidebar from './FrontAppSidebar.vue';
import { ref } from 'vue';

const menu = ref(false);
const userMenu = ref(false);

function toggleSidebar() {
    menu.value = !menu.value;
    userMenu.value = false;
}

function toggleUserMenu() {
    userMenu.value = !userMenu.value;
    menu.value = false;
}

</script>

<template>
    <header>
        <div class="grid h-24 grid-cols-2 place-content-between gap-4 py-4 bg-gray-900 text-white">
            <div class="px-4">
                <button @click="toggleSidebar">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
            <div class="px-4 flex items-center justify-end ">
                <button @click="toggleUserMenu">
                    <i class="fa-solid fa-user"></i>
                </button>
            </div>
            <div class="text-2xl px-4 col-span-2">
                <h2>My Manga Shelf</h2>
            </div>
        </div>
        <FrontAppSidebar v-show="menu" @close="menu = false"/>
        <FrontAppSidebar variant="right" v-show="userMenu" @close="userMenu = false"/>
    </header>
</template>
