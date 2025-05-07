<script setup>
import { computed } from 'vue';

const props = defineProps({
    price: [Number, String]
});

const formattedPrice = computed(
    () => Number(props.price).toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD',
        // currency: 'IDR',
        maximumFractionDigits: 0
    })
);
</script>

<template>
    <span>{{ formattedPrice }}</span>
</template>
