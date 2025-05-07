<template>
    <form>
        <div class="mb-4 mt-4 flex flex-wrap gap-4 items-center">
            <!-- Checkbox -->
            <div class="flex items-center gap-2">
                <input id="deleted" v-model="filterForm.deleted" type="checkbox"
                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                <label for="deleted" class="text-sm text-gray-700">Deleted</label>
            </div>

            <!-- Sort By & Order -->
            <div class="flex items-center gap-2">
                <select v-model="filterForm.by" class="input-filter-l w-28">
                    <option value="created_at">Added</option>
                    <option value="price">Price</option>
                </select>

                <select v-model="filterForm.order" class="input-filter-r w-32">
                    <option v-for="option in sortOptions" :key="option.value" :value="option.value">
                        {{ option.label }}
                    </option>
                </select>
            </div>
        </div>
    </form>
</template>

<script setup>
import { reactive, watch, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import { debounce } from 'lodash';

// Props
const props = defineProps({
    filters: Object,
});

// Reactive form
const filterForm = reactive({
    deleted: props.filters.deleted ?? false,
    by: props.filters.by ?? 'created_at',
    order: props.filters.order ?? 'desc',
});

// Dynamic sort options based on "by"
const sortLabels = {
    created_at: [
        { label: 'Latest', value: 'desc' },
        { label: 'Oldest', value: 'asc' },
    ],
    price: [
        { label: 'Pricey', value: 'desc' },
        { label: 'Cheapest', value: 'asc' },
    ],
};

const sortOptions = computed(() => {
    return sortLabels[filterForm.by] || [];
});

// Watch with debounce
watch(
    () => ({ ...filterForm }), // track object change
    debounce(() => {
        router.get(route('realtor.listing.index'), filterForm, {
            preserveScroll: true,
            preserveState: true,
        });
    }, 500),
    { deep: true }
);
</script>
