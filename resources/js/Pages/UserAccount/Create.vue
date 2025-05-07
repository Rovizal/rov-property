<template>
    <form @submit.prevent="register">
        <div class="w-full max-w-md mx-auto space-y-4">
            <div>
                <label for="name" class="label">Name</label>
                <input type="text" id="name" class="input" v-model="form.name" />
                <div class="input-error" v-if="form.errors.name">{{ form.errors.name }}</div>
            </div>

            <div>
                <label for="email" class="label">E-mail</label>
                <input type="email" id="email" class="input" v-model="form.email" />
                <div class="input-error" v-if="form.errors.email">{{ form.errors.email }}</div>
            </div>

            <div>
                <label for="password" class="label">Password</label>
                <input type="password" id="password" class="input" v-model="form.password" />
                <div class="input-error" v-if="form.errors.password">{{ form.errors.password }}</div>
            </div>

            <div>
                <label for="password_confirmation" class="label">Password Confirmation</label>
                <input type="password" id="password_confirmation" class="input" v-model="form.password_confirmation" />
                <div class="input-error" v-if="form.errors.password_confirmation">
                    {{ form.errors.password_confirmation }}
                </div>
            </div>

            <div>
                <button class="btn-primary w-full" type="submit">Create Account</button>
                <div class="mt-2 text-center">
                    <Link :href="route('login')" class="text-sm text-gray-500">Already have an Account? Click Here</Link>
                </div>
            </div>
        </div>
    </form>
</template>


<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';

const toast = useToast();
const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
});

const register = () => {
    form.post(route('user-account.store'), {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Account successfully created!')
            form.reset()
        },
        onError: () => {
            Object.values(form.errors).forEach((msg) => {
                toast.error(msg)
            });
        }
    })
};
</script>
