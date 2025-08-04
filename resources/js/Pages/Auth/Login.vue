<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import { defineOptions } from 'vue';

defineOptions({ layout: MainLayout });

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <!-- El fondo y el Head ahora están en el layout -->
    <div class="relative z-10 flex flex-col items-center justify-center min-h-screen p-4 text-white">
        <!-- Login Card -->
        <div class="w-full max-w-md p-8 space-y-6 shadow-2xl bg-gray-800/70 backdrop-blur-lg rounded-3xl">
            <!-- Logo -->
            <div class="flex flex-col items-center gap-4">
                <img src="/img/logo.png" alt="Game Logo" class="object-contain w-24 h-24 border-4 border-purple-500 rounded-full shadow-lg" />
                <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600">
                    Iniciar Sesión
                </h1>
            </div>

            <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                {{ status }}
            </div>

            <!-- Form -->
            <form @submit.prevent="submit" class="space-y-4">
                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-400">Correo Electrónico</label>
                    <input type="email"
                           id="email"
                           v-model="form.email"
                           placeholder="ejemplo@correo.com"
                           required
                           class="block w-full px-4 py-3 mt-1 text-white rounded-lg bg-gray-700/50 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-400">Contraseña</label>
                    <input type="password"
                           id="password"
                           v-model="form.password"
                           placeholder="********"
                           required
                           class="block w-full px-4 py-3 mt-1 text-white rounded-lg bg-gray-700/50 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label class="flex items-center">
                        <Checkbox v-model:checked="form.remember" name="remember" />
                        <span class="text-sm text-gray-400 ms-2">Recordarme</span>
                    </label>
                </div>

                <!-- Forgot Password Link -->
                <Link v-if="canResetPassword"
                      :href="route('password.request')"
                      class="text-sm text-purple-400 transition-colors duration-200 hover:text-purple-300">
                    ¿Olvidaste tu contraseña?
                </Link>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full px-6 py-3 font-bold text-white transition-all duration-200 transform rounded-lg shadow-lg bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 hover:scale-105"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing">
                    Iniciar Sesión
                </button>
            </form>

            <!-- Register Link -->
            <p class="text-center text-gray-400">
                ¿No tienes una cuenta?
                <Link :href="route('register')" class="text-purple-400 transition-colors duration-200 hover:text-purple-300">
                    Regístrate aquí
                </Link>
            </p>
        </div>
    </div>
</template>

<style scoped>
@keyframes float {
  0%, 100% {
    transform: translateY(0) rotate(0deg);
  }
  50% {
    transform: translateY(-20px) rotate(5deg);
  }
}

/* Gradient animation for buttons */
.bg-gradient-to-r {
  background-size: 200% auto;
  transition: background-position 0.5s ease;
}
.bg-gradient-to-r:hover {
  background-position: right center;
}
</style>
