<script setup>
defineProps({
    listing: Object
});
</script>

<template>
    <div>
        {{ listing.street }} {{ listing.street_nr }}, {{ listing.city }}
    </div>
</template>

<style scoped></style>
