<template>
    <h1 class="text-3xl mb-4">Your Listings</h1>
    <section>
        <RealtorFilters :filters="filters" />
    </section>
    <section v-if="listings.data.length" class="grid grid-cols-1 lg:grid-cols-2 gap-2">
        <Box v-for="listing in listings.data" :key="listing.id" :class="{ 'border-dashed': listing.deleted_at }">
            <div class="flex flex-col md:flex-row gap-2 md:items-center justify-between">
                <div :class="{ 'opacity-25': listing.deleted_at }">
                    <div class="xl:flex items-center gap-2">
                        <Price :price="listing.price" class="text-2xl font-medium" />
                        <ListingSpace :listing="listing" />
                    </div>
                    <ListingAddress :listing="listing" />
                </div>
                <div class="flex items-center gap-1 text-gray-600 dark:text-gray-300">
                    <Link :href="route('listing.show', { listing: listing.id })" class="btn-outline text-xs font-medium">Preview</Link>
                    <Link :href="route('realtor.listing.edit', { listing: listing.id })" class="btn-outline text-xs font-medium">Edit</Link>
                    <button v-if="!listing.deleted_at" @click="handleDelete(listing.id)" class="btn-outline text-xs font-medium">Delete</button>
                    <Link v-else :href="route('realtor.listing.restore', { listing: listing.id })" as="button" method="put"
                        class="btn-outline text-xs font-medium">Restore</Link>
                </div>
            </div>
            <div>
                <div class="mt-2">
                    <Link v-if="listing.images_count - 1" :href="route('realtor.listing.image.create', { listing: listing.id })"
                        class="block w-full btn-outline text-xs font-medium text-center">
                    Images ({{ listing.images_count }})
                    </Link>
                    <Link v-else :href="route('realtor.listing.image.create', { listing: listing.id })"
                        class="block w-full btn-outline text-xs font-medium text-center">
                    Image ({{ listing.images_count }})
                    </Link>
                </div>

                <div class="mt-2">
                    <Link :href="route('realtor.listing.show', { listing: listing.id })"
                        class="block w-full btn-outline text-xs font-medium text-center">
                    Offers ({{ listing.offers_count }})
                    </Link>
                </div>
            </div>
        </Box>
    </section>

    <EmptyState v-else>No Listings yet</EmptyState>

    <section v-if="listings.data.length" class="w-full flex justify-center mt-4 mb-4">
        <Pagination :links="listings.links" />
    </section>
</template>

<script setup>
import ListingAddress from '@/Components/ListingAddress.vue'
import ListingSpace from '@/Components/ListingSpace.vue'
import Price from '@/Components/Price.vue'
import Box from '@/Components/UI/Box.vue'
import { Link } from '@inertiajs/vue3';
import RealtorFilters from './Index/Components/RealtorFilters.vue';
import Pagination from '@/Components/UI/Pagination.vue';
import EmptyState from '@/Components/UI/EmptyState.vue';
import useSwal from '@/Composables/useSwal';
import { router } from '@inertiajs/vue3';

const swal = useSwal();

const handleDelete = (id) => {
    swal({
        title: 'Are you sure?',
        text: 'This will be moved to trash.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#e3342f',
        cancelButtonColor: '#6c757d',
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route('realtor.listing.destroy', { listing: id }), {
                preserveScroll: true,
                onSuccess: () => {
                    swal('Deleted!', 'The listing has been deleted.', 'success')
                },
            })
        }
    })
}

defineProps({
    listings: Object,
    filters: Object,
});
</script>
