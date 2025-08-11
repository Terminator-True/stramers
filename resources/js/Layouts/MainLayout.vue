<template>
    <Head title="Welcome" />
    <div class="relative min-h-screen overflow-hidden bg-gradient-to-br from-gray-900 via-purple-950 to-black">
        <!-- Background pattern -->
        <div class="absolute inset-0 z-0 pointer-events-none opacity-10">
            <div v-for="i in 100" :key="i"
                class="absolute w-2 h-2 bg-white rounded-full animate-pulse"
                :style="{
                    left: `${Math.random() * 100}%`,
                    top: `${Math.random() * 100}%`
                }">
            </div>
        </div>
        <!-- Animated cards background effect -->
        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
            <div
                v-for="(card, i) in cards"
                :key="`card-${i}`"
                class="absolute w-20 h-32 rounded-lg shadow-md bg-white/5 animate-rotating-floating-card"
                :style="{
                    left: `${card.left}%`,
                    top: `${card.top}%`,
                    '--start-rotate': `${card.rotation}deg`,
                    '--move-x': `${card.moveX}px`,
                    '--move-y': `${card.moveY}px`,
                    animationDuration: `${card.duration}s`,
                    animationDelay: `${card.delay}s`
                }"
            ></div>
        </div>
        <!-- Header absoluto -->
        <header class="fixed top-0 left-0 z-20 flex items-center justify-end w-full gap-6 px-8 py-4 bg-black/40 backdrop-blur-md">
            <div class="flex items-center gap-4">
                <span v-if="$page.props.userCredits !== undefined" class="flex items-center gap-1 text-lg font-bold text-yellow-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="10" fill="#FFD700"/></svg>
                    {{ $page.props.userCredits }}
                </span>
                <span v-if="$page.props.auth && $page.props.auth.user && $page.props.auth.user.level" class="flex items-center gap-1 text-lg font-bold text-blue-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 2l2.09 6.26L20 9.27l-5 3.64L16.18 20 12 16.77 7.82 20 9 12.91l-5-3.64 5.91-.91z" fill="#60A5FA"/></svg>
                    Nivel {{ $page.props.auth.user.level }}
                </span>
                <span v-if="$page.props.auth && $page.props.auth.user && $page.props.auth.user.name" class="flex items-center gap-1 text-lg font-semibold text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="8" r="4" fill="#fff"/><path d="M4 20c0-4 8-4 8-4s8 0 8 4v2H4v-2z" fill="#fff"/></svg>
                    {{ $page.props.auth.user.name }}
                </span>
            </div>
        </header>
        <div class="relative z-10 pt-20">
            <slot />
        </div>
    </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const cards = ref([]);
onMounted(() => {
    cards.value = Array(8).fill().map(() => ({
        left: Math.random() * 80 + 10, // 10% to 90%
        top: Math.random() * 80 + 10, // 10% to 90%
        rotation: Math.random() * 360,
        moveX: (Math.random() - 0.5) * 400, // -200px a 200px
        moveY: (Math.random() - 0.5) * 400, // -200px a 200px
        duration: 8 + Math.random() * 6, // 8s a 14s
        delay: Math.random() * -8
    }));
});
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
</style>
