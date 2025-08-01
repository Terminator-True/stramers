<template>
    <Head title="Welcome" />
    <div class="relative min-h-screen overflow-hidden bg-gradient-to-br from-gray-900 via-purple-950 to-black">
        <!-- Background pattern -->
        <div class="absolute inset-0 opacity-10">
            <div v-for="i in 100" :key="i" 
                class="absolute w-2 h-2 bg-white rounded-full animate-pulse"
                :style="{
                    left: `${Math.random() * 100}%`,
                    top: `${Math.random() * 100}%`
                }">
            </div>
        </div>
        <!-- Animated cards background effect -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div v-for="i in 8" :key="`card-${i}`" 
                class="absolute w-20 h-32 rounded-lg shadow-md bg-white/5 hover:animate-pulse"
                :style="getCardStyle(i)">
            </div> 
        </div>

        <!-- Main content -->
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
    </div>
</template>


<script setup>
    import { Head, Link } from '@inertiajs/vue3';
    import { ref, onMounted } from 'vue';
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
    
    const cards = ref([]);
    onMounted(() => {
        cards.value = Array(8).fill().map(() => ({
            left: Math.random() * 80 + 10, // 10% to 90%
            top: Math.random() * 80 + 10, // 10% to 90%
            rotation: Math.random() * 360,
            duration: 5 + Math.random() * 5,
            delay: Math.random() * -5
        }));
    });

    
    const getCardStyle = (index) => {
        return {
            left: `${ Math.random() * 80 + 10}%`,
            top: `${Math.random() * 80 + 10}%`,
            transform: `rotate(${Math.random() * 360}deg)`,
            animation: `float ${5 + Math.random() * 5}s infinite ease-in-out ${Math.random() * -5}s`
        };
    };

    // function handleImageError() {
    //     document.getElementById('screenshot-container')?.classList.add('!hidden');
    //     document.getElementById('docs-card')?.classList.add('!row-span-1');
    //     document.getElementById('docs-card-content')?.classList.add('!flex-row');
    //     document.getElementById('background')?.classList.add('!hidden');
    // }
</script>

<style scoped>
    @keyframes float {
        0%, 100% {
            transform: translateY(0) rotate(v-bind('card.rotation + "deg"'));
        }
        
        50% {
            transform: translateY(-20px) rotate(v-bind('card.rotation + "deg"'));
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