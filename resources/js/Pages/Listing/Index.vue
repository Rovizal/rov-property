<script setup>
import Pagination from '@/Components/UI/Pagination.vue';
import Listing from '@/Pages/Listing/Index/Components/Listing.vue';
import Filters from './Index/Components/Filters.vue';

// defineProps({
//     listings: Array
// });
defineProps({
    listings: Object,
    filters: Object
});

</script>

<template>
    <div>
        <Filters :filters="filters" />
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
            <Listing v-for="listing in listings.data" :key="listing.id" :listing="listing" />
        </div>

        <div v-if="listings.data.length" class="w-full flex justify-center mt-8 mb-8">
            <Pagination :links="listings.links" />
        </div>
    </div>
</template>

<style scoped></style>
