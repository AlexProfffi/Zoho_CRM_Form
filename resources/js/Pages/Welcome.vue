<template>
    <div>
        <Head>
            <title>Welcome</title>
        </Head>

        <div>{{ testString }}</div>
    </div>
</template>


<script setup>

// ======== Import ========

import MainLayout from "@/Layouts/MainLayout.vue";
import { Head } from '@inertiajs/vue3'


// ======== Options ========

defineOptions({ layout: MainLayout })


// ======== Props ========

const props = defineProps({
    testString: String,
})

</script>


<style scoped>

</style>
