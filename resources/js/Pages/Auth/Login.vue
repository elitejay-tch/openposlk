<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Mail, Lock, Eye, EyeOff } from 'lucide-vue-next';
import { ref } from 'vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const showPassword = ref(false);

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Sign In" />

        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-2xl font-semibold text-gray-900">Sign in</h2>
            <p class="mt-2 text-sm text-gray-600">
                Enter your credentials to access your account
            </p>
        </div>

        <!-- Status Message -->
        <div v-if="status" class="mb-6 p-3 bg-green-50 border border-green-200 rounded-md">
            <p class="text-sm font-medium text-green-600">{{ status }}</p>
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <!-- Email Field -->
            <div>
                <InputLabel for="email" value="Email address" class="text-gray-700 font-medium" />

                <div class="relative mt-1">
                    <TextInput
                        id="email"
                        type="email"
                        class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 transition-colors"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="Enter your email"
                    />
                    <Mail class="absolute left-3 top-3 h-4 w-4 text-gray-400" />
                </div>

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <!-- Password Field -->
            <div>
                <InputLabel for="password" value="Password" class="text-gray-700 font-medium" />

                <div class="relative mt-1">
                    <TextInput
                        id="password"
                        :type="showPassword ? 'text' : 'password'"
                        class="block w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 transition-colors"
                        v-model="form.password"
                        required
                        autocomplete="current-password"
                        placeholder="Enter your password"
                    />
                    <Lock class="absolute left-3 top-3 h-4 w-4 text-gray-400" />

                    <!-- Password toggle -->
                    <button
                        type="button"
                        @click="showPassword = !showPassword"
                        class="absolute right-3 top-3 text-gray-400 hover:text-gray-600 focus:outline-none transition-colors"
                    >
                        <Eye v-if="!showPassword" class="h-4 w-4" />
                        <EyeOff v-else class="h-4 w-4" />
                    </button>
                </div>

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <Checkbox
                    name="remember"
                    v-model:checked="form.remember"
                    class="h-4 w-4 text-gray-600 border-gray-300 rounded focus:ring-gray-400"
                />
                <span class="ml-2 text-sm text-gray-700">Remember me</span>
            </div>

            <!-- Submit Button -->
            <div class="space-y-4">
                <PrimaryButton
                    class="w-full justify-center py-2.5 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-900 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                    :class="{ 'opacity-50': form.processing }"
                    :disabled="form.processing"
                >
                    <span v-if="form.processing">Signing in...</span>
                    <span v-else>Sign in</span>
                </PrimaryButton>

                <!-- Forgot Password Link -->
                <div v-if="canResetPassword" class="text-center">
                    <Link
                        :href="route('password.request')"
                        class="text-sm text-gray-600 hover:text-gray-900 underline focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 rounded transition-colors"
                    >
                        Forgot your password?
                    </Link>
                </div>
            </div>
        </form>
    </GuestLayout>
</template>
