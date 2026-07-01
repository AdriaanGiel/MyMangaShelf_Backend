<script setup lang="ts">

import FrontAppShell from '@/components/FrontAppShell.vue';
import FrontContent from '@/components/FrontContent.vue';
import FrontFooter from '@/components/FrontFooter.vue';
import FrontHeader from '@/components/FrontHeader.vue';


</script>

<template>
    <FrontAppShell>
        <FrontHeader></FrontHeader>
        <FrontContent>
            <slot/>
        </FrontContent>
        <FrontFooter></FrontFooter>


    </FrontAppShell>
</template>
