<script setup>

function changeProvider() {
    console.log('Change provider clicked');
}

const props = defineProps({
    provider: {
        type: Object
    }
});
</script>

<template v-if="provider">
    <a @click.prevent="changeProvider" href="">
        <div class="py-4 w-24 h-24 mx-auto bg-white rounded">
            <span>{{ props.provider.name }}</span>  
        </div>
    </a>
</template>