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
        <div class="relative z-10">
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
