<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Welcome" />
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
            <!-- Logo -->
            <div class="mb-12 transform hover:scale-105 transition-transform duration-300">
                <img src="/img/logo.png" alt="Game Logo" class="w-64 h-64 object-contain shadow-lg rounded-full border-4 border-purple-500" />
            </div>

            <!-- Title -->
            <h1 class="text-5xl font-bold mb-4 text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600">
                Bienvenido a <span class="text-white">Stramers</span>
            </h1>

            <!-- Subtitle -->
            <p class="text-xl text-gray-400 mb-8 text-center max-w-lg">
                Sumérgete en un mundo de estrategia y magia. Construye tu mazo, domina el campo de batalla y conviértete en el mejor jugador.
            </p>

            <!-- Call to Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <Link :href="route('login')" 
                    class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200">
                    Iniciar Sesión
                </Link>
                <Link :href="route('register')" 
                    class="px-8 py-3 bg-gradient-to-r from-green-600 to-teal-600 hover:from-green-500 hover:to-teal-500 text-white font-bold rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200">
                    Registrarse
                </Link>
            </div>

            <!-- Features Section -->
            <div class="mt-12 space-y-8 text-center">
                <div class="flex flex-col items-center gap-2">
                    <span class="text-4xl text-purple-400">🔥</span>
                    <h2 class="text-2xl font-semibold text-white">Construye tu Mazo</h2>
                    <p class="text-gray-400">Crea estrategias únicas combinando cartas poderosas.</p>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <span class="text-4xl text-purple-400">⚔️</span>
                    <h2 class="text-2xl font-semibold text-white">Desafía a Jugadores</h2>
                    <p class="text-gray-400">Enfréntate a otros jugadores en emocionantes partidas.</p>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <span class="text-4xl text-purple-400">🏆</span>
                    <h2 class="text-2xl font-semibold text-white">Gana Recompensas</h2>
                    <p class="text-gray-400">Sube de nivel y obtén recompensas exclusivas.</p>
                </div>
            </div>
        </div>

        <footer class="py-16 text-center text-sm text-black dark:text-white/70">
            @2025
        </footer>
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