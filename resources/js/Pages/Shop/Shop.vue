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
        Tienda de Cartas
      </h1>
      
      <button @click="getCardID(1)" > card </button>

      <!-- Sobres Section -->
      <div class="w-full max-w-4xl bg-gray-800/50 backdrop-blur-lg rounded-lg p-6 shadow-md mb-8">
        <h2 class="text-2xl font-semibold mb-4 text-purple-400">Sobres de Cartas</h2>
        <div class="flex justify-around gap-4">
          <div v-for="pack in packs" :key="pack.type" class="flex flex-col items-center gap-2">
            <button @click="buyPack(pack.type)" class="w-32 h-32 bg-gradient-to-b from-blue-600 to-indigo-700 hover:from-blue-500 hover:to-indigo-600 rounded-lg shadow-md transform hover:scale-105 transition-all duration-200">
              <span class="text-white font-bold text-xl">{{ pack.name }}</span>
            </button>
            <p class="text-gray-400">{{ pack.price }} Coins</p>
          </div>
        </div>
      </div>

      <button @click="$inertia.visit(route('dashboard'))" class="absolute top-6 left-6 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        <!-- Volver al Menú -->
      </button>
      
      <!-- Ruleta Section -->
      <div class="w-full max-w-4xl bg-gray-800/50 backdrop-blur-lg rounded-lg p-6 shadow-md mb-8">
        <h2 class="text-2xl font-semibold mb-4 text-purple-400">Ruleta de Cartas</h2>
        <div class="flex flex-col items-center gap-4">
          <div class="relative w-64 h-64 bg-gradient-to-b from-yellow-500 to-orange-600 rounded-full shadow-md">
            <div class="absolute inset-0 flex items-center justify-center">
              <span class="text-2xl font-bold text-white">GIRAR</span>
            </div>
          </div>
          <button @click="spinWheel" class="px-6 py-2 bg-gradient-to-r from-green-500 to-teal-500 hover:from-green-400 hover:to-teal-400 text-white font-bold rounded-lg shadow-md transform hover:scale-105 transition-all duration-200">
            Girar Ruleta (50 Coins)
          </button>
        </div>
      </div>

      <!-- Tienda de Cartas Individuales -->
      <div class="w-full max-w-4xl bg-gray-800/50 backdrop-blur-lg rounded-lg p-6 shadow-md">
        <h2 class="text-2xl font-semibold mb-4 text-purple-400">Cartas Individuales</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div v-for="card in cards" :key="card.id" class="bg-gray-700/50 backdrop-blur-lg rounded-lg p-4 shadow-md flex flex-col items-center gap-2">
            <img :src="card.image" alt="Card Image" class="w-24 h-32 object-cover rounded-lg" />
            <p class="text-lg font-semibold">{{ card.name }}</p>
            <p class="text-gray-400">{{ card.price }} Coins</p>
            <button @click="buyCard(card.id)" class="px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-400 hover:to-indigo-500 text-white font-bold rounded-lg shadow-sm transform hover:scale-105 transition-all duration-200">
              Comprar
            </button>
          </div>
        </div>
      </div>


      <Card :card="card" class=" mt-10 " />

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
import Card from '@/Components/Cards/Card.vue';
import axios from 'axios';

export default {
  name: 'ShopPage',
  components: {
    Card,
  },
  data() {
    return {
      card: [],
      packs: [
        { type: 'basic', name: 'Básico', price: 100 },
        { type: 'super', name: 'Súper', price: 300 },
        { type: 'mega', name: 'Mega', price: 500 },
      ],
      cards: [
        { id: 1, name: 'Carta Fuego', price: 50, image: '/img/card-fire.png' },
        { id: 2, name: 'Carta Hielo', price: 75, image: '/img/card-ice.png' },
        { id: 3, name: 'Carta Naturaleza', price: 100, image: '/img/card-nature.png' },
      ],
    };
  },
  methods: {
    buyPack(type) {
      console.log(`Has comprado un sobre ${type}`);
    },
    spinWheel() {
      console.log('¡Girando la ruleta!');
    },
    buyCard(id) {
      const card = this.cards.find((c) => c.id === id);
      console.log(`Has comprado la carta "${card.name}" por ${card.price} coins.`);
    },
    getCardID(id) {
      return axios.get(route('get.card.id', { id: id }))
        .then(response => {
          console.log(response.data);
          this.card = response.data;
        })
        .catch(error => {
          console.error('Error al obtener la carta:', error);
          throw error;
        });
    },
  },
  mounted() {
    this.getCardID(1);
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