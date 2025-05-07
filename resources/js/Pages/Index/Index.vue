<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import MainLayout from '../../Layouts/MainLayout.vue';

// const counter = ref(0);
const props = defineProps(['message']);

console.log(props.message);

// setInterval(() => counter.value++, 1000);
</script>

<template>
    <!-- <MainLayout> -->
    <div>
        The Message is {{ props.message }}
    </div>
    <Link href="/hello">Show Page</Link>
    <!-- </MainLayout> -->
</template>
