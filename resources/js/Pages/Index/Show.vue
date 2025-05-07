<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import MainLayout from '../../Layouts/MainLayout.vue';

const counter = ref(0);

// setInterval(() => counter.value++, 1000);
</script>

<template>
    <!-- <MainLayout> -->
    <div>Show! {{ counter }}</div>
    <Link href="/">Index Page</Link>
    <!-- </MainLayout> -->
</template>
