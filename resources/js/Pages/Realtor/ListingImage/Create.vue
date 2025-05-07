<template>
    <Box>
        <template #header>Upload New Images</template>
        <form @submit.prevent="upload" enctype="multipart/form-data">
            <section class="flex items-center gap-2 my-0">
                <input type="hidden" name="_token" :value="csrfToken">
                <input
                    class="border rounded-md file:px-4 file:py-2 border-gray-200 dark:border-gray-700 file:text-gray-700 file:dark:text-gray-400 file:border-0 file:bg-gray-100 file:dark:bg-gray-800 file:font-medium file:hover:bg-gray-200 file:dark:hover:bg-gray-700 file:hover:cursor-pointer file:mr-4"
                    type="file" multiple @change="addFiles" />
                <button type="submit" class="btn-outline disabled:opacity-25 disabled:cursor-not-allowed" :disabled="canUpload">Upload</button>
                <button type="reset" @click="reset" class="btn-outline">Reset</button>
            </section>
            <div v-if="imageErrors.length" class="input-error">
                <div v-for="(error, index) in imageErrors" :key="index">
                    {{ error }}
                </div>

            </div>
        </form>
    </Box>

    <Box v-if="listing.images.length > 0" class="mt-4">
        <template #header>Current Listing Images</template>
        <section class="mt-4 grid grid-cols-3 gap-4">
            <div v-for="image in listing.images" :key="image.id" class="flex flex-col justify-between">
                <img :src="image.src" class="rounded-md" />
                <Link :href="route('realtor.listing.image.destroy', { listing: props.listing.id, image: image.id })" method="delete" as="button"
                    class="mt-2 btn-outline">
                Delete
                </Link>
            </div>
        </section>
    </Box>
</template>

<script setup>
import Box from '@/Components/UI/Box.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import nProgress from 'nprogress';
import { onMounted, onBeforeUnmount } from 'vue';

let progressListenerAttached = false;

onMounted(() => {
    if (!progressListenerAttached) {
        Inertia.on('progress', (event) => {
            if (event.detail.progress.percentage) {
                nProgress.set((event.detail.progress.percentage / 100) * 0.9);
            }
        });
        progressListenerAttached = true;
    }
});

const { csrf_token } = usePage().props;
const csrfToken = csrf_token;

const props = defineProps({ listing: Object });

const form = useForm({
    images: []
});

const imageErrors = computed(() => Object.values(form.errors));

const canUpload = computed(() => form.images.length === 0);

const upload = () => {
    nProgress.start();
    form.post(route('realtor.listing.image.store', { listing: props.listing.id }), {
        forceFormData: true,
        onSuccess: () => {
            form.reset('images');
            nProgress.done();
        },
        onError: () => {
            nProgress.done();
        },
        onFinish: () => {
            nProgress.done();
        }
    });
};

const addFiles = (event) => {
    form.images = Array.from(event.target.files);
};
</script>
