<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import FrontAppLayout from '@/layouts/FrontAppLayout.vue';
import MangaModal from '../components/MangaModal.vue';
import ProviderCard from '../components/ProviderCard.vue';
import { ref,computed } from 'vue';

let showModal = ref(false);

const options = computed(() => {
    return props.media.providers.length > 1;
});

const props = defineProps({
    media: {
        type: Object
    }
});

function openMediaTab() {
    window.open(props.media.providers[0].url, '_blank');
}

</script>

<template>
    <Head title="My Shelf" />

    <FrontAppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My Shelf
            </h2>
        </template>
        <div class="px-2 py-2 flex flex-col gap-4">
            <div class=" py-2 px-4 w-full flex flex-col place-content-between h-44 bg-red-500 rounded-2xl">
                <h2 class=" text-2xl w-full font-bold">{{ media.title }}</h2>

                <span v-for="(author,index) in props.media.authors" class="text-xl text-right w-full ">{{ author.name }}</span>
            </div>
            <button @click="openMediaTab" class="w-full py-3 bg-white rounded-xl text-xl font-bold text-black"><i class="fa-solid fa-book"></i> Continue</button>

            <div class="w-full px-2 flex flex-col gap-2 text-white">
                <div class="flex flex-row">
                    <span class="text-sm text-gray-400font-bold">Ongoing</span>
                    <span class="ml-auto text-sm text-gray-400">Last read: Chapter 1050</span>
                </div>

                <p>{{ media.description }}</p>
                <div class="flex flex-col gap-2 place-self-center text-center">
                 <h2 class="text-lg font-bold">Your Provider</h2>
                <ProviderCard :provider="media.providers[0]"/>
                <button :class="options ? 'bg-purple-600' : 'bg-purple-300'" @click="showModal = true" class="p-2 text-sm  rounded">Choose new provider</button>

                </div>
            </div>

        </div>
         <Teleport v-if="options" to="body">
            <MangaModal v-show="showModal" @close="showModal = false">
                <h2 class="text-2xl font-bold">Providers</h2>
                <div class="flex flex-wrap gap-2 justify-center">
                    <ProviderCard v-for="(provider, index) in media.providers" :key="index" :provider="provider" />
                
                </div>
            </MangaModal>
        </Teleport>

    </FrontAppLayout>

</template>
