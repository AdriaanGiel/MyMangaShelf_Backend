<script setup>

</script>

<template>
    <div class="w-full h-full flex justify-center items-center text-center absolute top-0 left-0">
        <div class="w-full h-full bg-black absolute top-0 left-0 opacity-70 z-10"></div>
        <div class="w-11/12 h-6/12 flex flex-col place-content-between z-20 bg-gray-900 rounded-lg shadow-lg p-2">
        <slot></slot>
        <button @click="$emit('close')">Close</button>
        </div>

    </div>
</template>



