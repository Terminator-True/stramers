<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import InputError from '@/Components/InputError.vue';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <Head title="Forgot Password" />
    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-purple-950 to-black relative overflow-hidden">
        <!-- Background pattern -->
        <div class="absolute inset-0 opacity-10">
            <div v-for="i in 100" :key="i" 
                class="h-2 w-2 bg-white rounded-full absolute animate-pulse"
                :style="{
                    left: `${Math.random() * 100}%`,
                    top: `${Math.random() * 100}%`
                }">
            </div>
        </div>

        <!-- Animated cards background effect -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div v-for="i in 8" :key="`card-${i}`" 
                class="absolute w-20 h-32 bg-white/5 rounded-lg shadow-md"
                :style="{
                    left: `${Math.random() * 100}%`,
                    top: `${Math.random() * 100}%`,
                    transform: `rotate(${Math.random() * 360}deg)`,
                    animation: `float ${5 + Math.random() * 5}s infinite ease-in-out`
                }">
            </div>
        </div>

        <!-- Main content -->
        <div class="relative z-10 flex flex-col items-center justify-center min-h-screen p-4 text-white">
            <!-- Forgot Password Card -->
            <div class="w-full max-w-md bg-gray-800/70 backdrop-blur-lg rounded-3xl p-8 shadow-2xl space-y-6">
                <!-- Logo -->
                <div class="flex flex-col items-center gap-4">
                    <img src="/img/logo.png" alt="Game Logo" class="w-24 h-24 object-contain shadow-lg rounded-full border-4 border-purple-500" />
                    <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600">
                        Recuperar Contraseña
                    </h1>
                </div>

                <div class="text-sm text-gray-400">
                    ¿Olvidaste tu contraseña? No hay problema. Solo indícanos tu dirección de correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
                </div>

                <div v-if="status" class="font-medium text-sm text-green-600">
                    {{ status }}
                </div>

                <form @submit.prevent="submit" class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-400">Correo Electrónico</label>
                        <input
                            id="email"
                            v-model="form.email"
                            type="email"
                            placeholder="ejemplo@correo.com"
                            required
                            autofocus
                            class="mt-1 block w-full px-4 py-3 bg-gray-700/50 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <button
                        type="submit"
                        class="w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Enviar Enlace de Recuperación
                    </button>
                </form>

                <!-- Back to Login Link -->
                <p class="text-center text-gray-400">
                    <a :href="route('login')" class="text-purple-400 hover:text-purple-300 transition-colors duration-200">
                        Volver al inicio de sesión
                    </a>
                </p>
            </div>
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

.bg-gradient-to-r {
    background-size: 200% auto;
    transition: background-position 0.5s ease;
}
.bg-gradient-to-r:hover {
    background-position: right center;
}
</style>
