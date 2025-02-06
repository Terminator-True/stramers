<template>
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
    
    <!-- Main content -->
    <div class="relative z-10 flex flex-col items-center justify-center min-h-screen p-4 text-white">
      <!-- Header -->
      <h1 class="text-4xl font-bold mb-8 text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600">
        Mis Mazos
      </h1>
      
      <!-- Create New Deck Button -->
      <button @click="$inertia.visit(route('create.deck'))" class="mb-8 px-6 py-3 bg-gradient-to-r from-green-500 to-teal-500 hover:from-green-400 hover:to-teal-400 text-white font-bold rounded-lg shadow-md transform hover:scale-105 transition-all duration-200">
        Crear Nuevo Mazo
      </button>

      <!-- Deck List -->
      <div class="w-full max-w-4xl space-y-4">
        <div v-if="localDecks.length === 0" class="text-center text-gray-400 text-lg">
          No tienes mazos creados. ¡Crea uno nuevo!
        </div>
        <div v-for="deck in localDecks" :key="deck.id" class="flex items-center justify-between bg-gray-800/50 backdrop-blur-lg rounded-lg p-4 shadow-md">
          <!-- Deck Info -->
          <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-gradient-to-br from-purple-600 to-pink-600 rounded-full flex items-center justify-center text-white font-bold text-xl">
              {{ deck.name.charAt(0).toUpperCase() }}
            </div>
            <div>
              <p class="text-lg font-semibold">{{ deck.name }}</p>
              <p class="text-sm text-gray-400">ID: {{ deck.id }}</p>
            </div>
          </div>

          <!-- Actions -->
          <div class="flex gap-2">
            <button @click="$inertia.visit(route('deck.show', {deck: deck.id} ))" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-lg shadow-sm transform hover:scale-105 transition-all duration-200">
              Editar
            </button>
            <button @click="deleteDeck(deck.id)" class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white rounded-lg shadow-sm transform hover:scale-105 transition-all duration-200">
              Eliminar
            </button>
          </div>
        </div>

        <button @click="$inertia.visit(route('dashboard'))" class="absolute top-6 left-6 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
          <!-- Volver al Menú -->
      </button>

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
  </div>
  </template>
  
  <script>
import axios from 'axios';

  export default {

    props: ['decks'],
  data() {
    return {
      newDeckName: "",
      localDecks: this.decks // Crea una copia local de los decks
    };
  },
  methods: {
    deleteDeck(id) {
    if (confirm('¿Estás seguro de que quieres eliminar este deck?')) {
      axios.delete(route(`deck.destroy`, {deck: id}))
        .then(response => {
          console.log('Deck eliminado con éxito');
          this.localDecks = this.localDecks.filter(deck => deck.id !== id);
          this.$toast.success('Deck eliminado correctamente');
        })
        .catch(error => {
          console.error('Error al eliminar el deck:', error);
          this.$toast.error('Error al eliminar el deck');
        });
    }
  }
}

};
  </script>

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
  