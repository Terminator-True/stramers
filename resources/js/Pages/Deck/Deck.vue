<template>
  <div class="relative min-h-screen overflow-hidden bg-gradient-to-br from-gray-900 via-purple-950 to-black">
    <!-- Background pattern -->
    <!-- <div class="absolute inset-0 opacity-10">
      <div v-for="i in 100" :key="i"
      class="absolute w-2 h-2 bg-white rounded-full animate-pulse"
      :style="{
        left: `${Math.random() * 100}%`,
        top: `${Math.random() * 100}%`
      }">
      </div>
    </div> -->

    <!-- Main content -->
    <div class="relative z-10 flex flex-col items-center justify-center min-h-screen p-4 text-white">
      <!-- Header -->
      <h1 class="mb-8 text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600">
        Mis Mazos
      </h1>

      <!-- Create New Deck Button -->
      <button @click="$inertia.visit(route('create.deck'))" class="px-6 py-3 mb-8 font-bold text-white transition-all duration-200 transform rounded-lg shadow-md bg-gradient-to-r from-green-500 to-teal-500 hover:from-green-400 hover:to-teal-400 hover:scale-105">
        Crear Nuevo Mazo
      </button>

      <!-- Deck List -->
      <div class="w-full max-w-4xl space-y-4">
        <div v-if="localDecks.length === 0" class="text-lg text-center text-gray-400">
          No tienes mazos creados. ¡Crea uno nuevo!
        </div>
        <div v-for="deck in localDecks" :key="deck.id" class="flex items-center justify-between p-4 rounded-lg shadow-md bg-gray-800/50 backdrop-blur-lg">
          <!-- Deck Info -->
          <div class="flex items-center gap-4">
            <div class="flex items-center justify-center w-12 h-12 text-xl font-bold text-white rounded-full bg-gradient-to-br from-purple-600 to-pink-600">
              {{ deck.name.charAt(0).toUpperCase() }}
            </div>
            <div>
              <p class="text-lg font-semibold">{{ deck.name }}</p>
              <p class="text-sm text-gray-400">ID: {{ deck.id }}</p>
            </div>
          </div>

          <!-- Actions -->
          <div class="flex gap-2">
            <button @click="$inertia.visit(route('deck.show', {deck: deck.id} ))" class="px-4 py-2 text-white transition-all duration-200 transform bg-blue-600 rounded-lg shadow-sm hover:bg-blue-500 hover:scale-105">
              Editar
            </button>
            <button @click="deleteDeck(deck.id)" class="px-4 py-2 text-white transition-all duration-200 transform bg-red-600 rounded-lg shadow-sm hover:bg-red-500 hover:scale-105">
              Eliminar
            </button>
          </div>
        </div>

        <button @click="$inertia.visit(route('dashboard'))" class="absolute flex items-center gap-2 px-6 py-3 font-bold text-white transition-all duration-200 transform rounded-lg shadow-lg top-6 left-6 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 hover:scale-105">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
          <!-- Volver al Menú -->
      </button>

      </div>
    </div>

    <!-- Animated cards background effect -->
    <!-- <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div v-for="i in 8" :key="`card-${i}`"
           class="absolute w-20 h-32 rounded-lg shadow-md bg-white/5"
           :style="{
             left: `${Math.random() * 100}%`,
             top: `${Math.random() * 100}%`,
             transform: `rotate(${Math.random() * 360}deg)`,
             animation: `float ${5 + Math.random() * 5}s infinite ease-in-out`
           }">
      </div>
    </div> -->
  </div>
  </template>

<script setup>
import { ref } from 'vue';
// import { useToast } from 'vue-toastification';
import { router } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import axios from 'axios';

const props = defineProps({
    decks: {
        type: Array,
        required: true
    }
});

// const toast = useToast();
const localDecks = ref([...props.decks]);

function deleteDeck(id) {
    if (confirm('¿Estás seguro de que quieres eliminar este deck?')) {
        axios.delete(route('deck.destroy', { deck: id }))
            .then(() => {
                localDecks.value = localDecks.value.filter(deck => deck.id !== id);
                // toast.success('Deck eliminado correctamente');
            })
            .catch(error => {
                console.error('Error al eliminar el deck:', error);
                toast.error('Error al eliminar el deck');
            });
    }
}
defineOptions({
    layout: MainLayout
});

</script>

<!-- <style scoped>
@keyframes float {
  0%, 100% {
    transform: translateY(0) rotate(0deg);
  }
  50% {
    transform: translateY(-20px) rotate(5deg);
  }
}

/* Nueva animación para las estrellas */
@keyframes floating-star {
  0% {
    opacity: 0.7;
    transform: translateY(0) scale(1);
  }
  50% {
    opacity: 1;
    transform: translateY(-40px) scale(1.2);
  }
  100% {
    opacity: 0.7;
    transform: translateY(0) scale(1);
  }
}

</style> -->
