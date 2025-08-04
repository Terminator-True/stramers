<template>
    <!-- El fondo y el Head ahora están en el layout -->
    <div class="relative z-10 flex flex-col items-center justify-center min-h-screen p-4 text-white">
        <!-- Logo -->
        <div class="mb-12 transition-transform duration-300 transform hover:scale-105">
            <img src="/img/logo.png" alt="Game Logo" class="object-contain w-64 h-64 border-4 border-purple-500 rounded-full shadow-lg" />
        </div>

        <!-- Title -->
        <h1 class="mb-4 text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600">
            Bienvenido a <span class="text-white">Stramers</span>
        </h1>

        <!-- Subtitle -->
        <p class="max-w-lg mb-8 text-xl text-center text-gray-400">
            Sumérgete en un mundo de estrategia y magia. Construye tu mazo, domina el campo de batalla y conviértete en el mejor jugador.
        </p>

        <!-- Call to Action Buttons -->
        <div class="flex flex-col gap-4 sm:flex-row">
            <Link :href="route('login')"
                class="px-8 py-3 font-bold text-white transition-all duration-200 transform rounded-lg shadow-lg bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 hover:scale-105">
                Iniciar Sesión
            </Link>
            <Link :href="route('register')"
                class="px-8 py-3 font-bold text-white transition-all duration-200 transform rounded-lg shadow-lg bg-gradient-to-r from-green-600 to-teal-600 hover:from-green-500 hover:to-teal-500 hover:scale-105">
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
    <footer class="py-16 text-sm text-center text-black dark:text-white/70">
        @2025
    </footer>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { defineOptions } from 'vue';
import MainLayout from '@/Layouts/MainLayout.vue';

defineOptions({ layout: MainLayout });
</script>

<style scoped>
@keyframes rotating-floating-card {
    0% {
        transform: translate(0, 0) rotate(var(--start-rotate, 0deg)) scale(1);
    }
    20% {
        transform: translate(calc(var(--move-x, 0px) * 0.3), calc(var(--move-y, 0px) * 0.3)) rotate(calc(var(--start-rotate, 0deg) + 60deg)) scale(1.05);
    }
    50% {
        transform: translate(var(--move-x, 0px), var(--move-y, 0px)) rotate(calc(var(--start-rotate, 0deg) + 180deg)) scale(1.12);
    }
    80% {
        transform: translate(calc(var(--move-x, 0px) * 0.3), calc(var(--move-y, 0px) * 0.3)) rotate(calc(var(--start-rotate, 0deg) + 300deg)) scale(1.05);
    }
    100% {
        transform: translate(0, 0) rotate(calc(var(--start-rotate, 0deg) + 360deg)) scale(1);
    }
}

.animate-rotating-floating-card {
    animation-name: rotating-floating-card;
    animation-timing-function: ease-in-out;
    animation-iteration-count: infinite;
    will-change: transform;
}

    .bg-gradient-to-r {
        background-size: 200% auto;
        transition: background-position 0.5s ease;
        }
    .bg-gradient-to-r:hover {
        background-position: right center;
    }
</style>

<!-- <style scoped>
@keyframes float {
  0%, 100% {
    transform: translateY(0) rotate(v-bind(card.rotation + 'deg'));
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
</style> -->
