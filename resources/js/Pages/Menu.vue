<!-- <template>
    <div class="min-h-screen bg-gray-900 relative overflow-hidden">
      <div class="absolute inset-0 opacity-10">
        <div v-for="i in 100" :key="i" 
             class="h-2 w-2 bg-white rounded-full absolute"
             :style="{
               left: `${Math.random() * 100}%`,
               top: `${Math.random() * 100}%`
             }">
        </div>
      </div>
  
      <div class="relative z-10 flex flex-col items-center justify-center min-h-screen p-4">
        <div class="mb-12 transform hover:scale-105 transition-transform duration-300">
          <img :src="'/img/logo.png'" alt="Stramers Logo" class="w-64 h-64 object-contain" />
        </div>
  
        <div class="flex flex-wrap justify-center gap-4 max-w-4xl w-full mb-8">
          <div class="bg-gray-700/50 p-3 rounded-lg backdrop-blur-sm border border-gray-600 hover:border-gray-500 transition-colors">
            <a :href="route('profile.show')" class="text-gray-300 text-sm mb-1">Profile</a>
            <div class="bg-gray-800/70 px-4 py-2 rounded text-white">
                {{ name }}
            </div>
          </div>
  
          <div class="flex-1 min-w-[300px] bg-gray-800/30 rounded-xl backdrop-blur-sm p-2 flex gap-2">
            <a :href="route('play')" class="flex-1 text-center bg-blue-600 hover:bg-blue-500 text-white py-3 px-6 rounded-lg transform hover:scale-105 transition-all duration-200 font-bold text-lg shadow-lg hover:shadow-blue-500/50">
              PLAY
            </a>
            <a :href="route('deck')" class="flex-1 text-center bg-green-600 hover:bg-green-500 text-white py-3 px-6 rounded-lg transform hover:scale-105 transition-all duration-200 font-bold text-lg shadow-lg hover:shadow-green-500/50">
              COLLECTION
            </a>
            <a :href="route('shop')" class="flex-1 text-center  bg-purple-600 hover:bg-purple-500 text-white py-3 px-6 rounded-lg transform hover:scale-105 transition-all duration-200 font-bold text-lg shadow-lg hover:shadow-purple-500/50">
              Tienda
            </a>
          </div>
  
          <div class="flex flex-col gap-2">
            <button class="bg-orange-500 hover:bg-orange-400 text-white py-3 px-6 rounded-lg transform hover:scale-105 transition-all duration-200 font-bold shadow-lg hover:shadow-orange-500/50">
              OPTIONS
            </button>
            <button class="bg-red-600 hover:bg-red-500 text-white py-3 px-6 rounded-lg transform hover:scale-105 transition-all duration-200 font-bold shadow-lg hover:shadow-red-500/50">
              QUIT
            </button>
          </div>
        </div>
  
        <div class="flex gap-4">
          <button class="px-6 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-full transform hover:scale-105 transition-all duration-200">
            Lang
          </button>
          <button class="px-6 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-full transform hover:scale-105 transition-all duration-200">
            Discord
          </button>
          <button class="px-6 py-2 bg-blue-400 hover:bg-blue-300 text-white rounded-full transform hover:scale-105 transition-all duration-200">
            Twitter
          </button>
        </div>
      </div>
  
      <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div v-for="i in 8" :key="`card-${i}`" 
             class="absolute w-16 h-24 bg-white/5 rounded-lg"
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
  export default {
    name: 'HomePage',
    
  }
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
  
  /* Add some card suit symbols as pseudo-elements */
  .bg-white\/5:nth-child(4n)::before {
    content: '♠️';
  }
  .bg-white\/5:nth-child(4n+1)::before {
    content: '♥️';
  }
  .bg-white\/5:nth-child(4n+2)::before {
    content: '♣️';
  }
  .bg-white\/5:nth-child(4n+3)::before {
    content: '♦️';
  }

  .bg-white\/5::before {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 1.5rem;
    opacity: 0.2;
  }
</style> -->

<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-900 via-purple-950 to-black relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
      <div v-for="i in 100" :key="i" 
           class="h-2 w-2 bg-white rounded-full absolute animate-pulse"
           :style="{
             left: `${Math.random() * 100}%`,
             top: `${Math.random() * 100}%`
           }">
      </div>
    </div>

    <div class="relative z-10 flex flex-col items-center justify-center min-h-screen p-4 text-white">
      <div class="mb-12 transform hover:scale-105 transition-transform duration-300">
        <img :src="'/img/logo.png'" alt="Stramers Logo" class="w-64 h-64 object-contain shadow-lg rounded-full border-4 border-purple-500" />
      </div>

      <div class="flex flex-row flex-wrap justify-center gap-6 max-w-4xl w-full mb-8">
        <div class="bg-gray-700/50 p-4 rounded-2xl backdrop-blur-lg border border-gray-600 hover:border-gray-500 transition-colors shadow-md">
          <a :href="route('profile.show')" class="text-gray-300 text-sm font-medium mb-1 block">Profile</a>
          <div class="bg-gray-800/70 px-4 py-2 rounded-lg text-white font-bold">
            {{ name }}
          </div>
        </div>

        <div class="flex-1 min-w-[300px] bg-gray-800/30 rounded-3xl backdrop-blur-lg p-4 flex gap-4">
          <button @click="openModal" class="flex-1 text-center bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white py-3 px-6 rounded-lg transform hover:scale-105 transition-all duration-200 font-bold text-lg shadow-lg hover:shadow-blue-500/50">
            PLAY
          </button>
          <a :href="route('deck')" class="flex-1 text-center bg-gradient-to-r from-green-600 to-teal-600 hover:from-green-500 hover:to-teal-500 text-white py-3 px-6 rounded-lg transform hover:scale-105 transition-all duration-200 font-bold text-lg shadow-lg hover:shadow-green-500/50">
            COLLECTION
          </a>
          <a :href="route('shop')" class="flex-1 text-center bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-500 hover:to-pink-500 text-white py-3 px-6 rounded-lg transform hover:scale-105 transition-all duration-200 font-bold text-lg shadow-lg hover:shadow-purple-500/50">
            Tienda
          </a>
        </div>

        <div class="flex flex-col gap-4">
          <button class=" bg-gradient-to-r from-orange-500 to-yellow-500 hover:from-orange-400 hover:to-yellow-400 text-white py-3 px-6 rounded-lg transform hover:scale-105 transition-all duration-200 font-bold shadow-lg hover:shadow-orange-500/50">
            OPTIONS
          </button>
          <button class=" bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-500 hover:to-rose-500 text-white py-3 px-6 rounded-lg transform hover:scale-105 transition-all duration-200 font-bold shadow-lg hover:shadow-red-500/50">
            QUIT
          </button>
        </div>
      </div>

      <div class="flex gap-4">
        <button class="px-6 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-full transform hover:scale-105 transition-all duration-200 shadow-md">
          Lang
        </button>
        <button class="px-6 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-full transform hover:scale-105 transition-all duration-200 shadow-md">
          Discord
        </button>
        <button class="px-6 py-2 bg-sky-500 hover:bg-sky-400 text-white rounded-full transform hover:scale-105 transition-all duration-200 shadow-md">
          Twitter
        </button>
      </div>
    </div>

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
    <SelectGame
      v-if="isModalOpen"
      :selected-deck="selectedDeck"
      :selected-mode="selectedMode"
      @close="closeModal"
      @start="startGame"
      @update:selected-deck="selectedDeck = $event"
      @update:selected-mode="selectedMode = $event"
    ></SelectGame>
  </div>
</template>

<script>
import SelectGame from '@/Components/Modal/SelectGame.vue';

export default {
  name: 'HomePage',
  components: {
    SelectGame
  },
  data(){
    return{
      isModalOpen: false,
      selectedDeck: null,
      selectedMode: 'casual',
    }
  },
  methods: {
    openModal() {
      this.isModalOpen = true;
    },
    closeModal() {
      this.isModalOpen = false;
    },
    startGame() {
      if (!this.selectedDeck) {
        console.log('selecciona un mazo.');
        return;
      }
      console.log(`Buscando partida con:\nMazo: ${this.decks.find(deck => deck.id === this.selectedDeck).name}\nModo: ${this.selectedMode}`);
      // Aquí puedes redirigir a la pantalla de búsqueda de partida o iniciar la lógica del juego.
      this.closeModal();
    },
  },
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

.bg-white\/5:nth-child(4n)::before {
  content: '♠️';
}
.bg-white\/5:nth-child(4n+1)::before {
  content: '♥️';
}
.bg-white\/5:nth-child(4n+2)::before {
  content: '♣️';
}
.bg-white\/5:nth-child(4n+3)::before {
  content: '♦️';
}
.bg-white\/5::before {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  font-size: 1.5rem;
  opacity: 0.2;
}


.bg-gradient-to-r {
  background-size: 200% auto;
  transition: background-position 0.5s ease;
}
.bg-gradient-to-r:hover {
  background-position: right center;
}
</style>