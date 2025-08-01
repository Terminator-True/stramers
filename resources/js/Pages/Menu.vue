<template>
  <div class="relative min-h-screen overflow-hidden bg-gradient-to-br from-gray-900 via-purple-950 to-black">
    <div class="absolute inset-0 opacity-10">
      <div v-for="i in 100" :key="i"
           class="absolute w-2 h-2 bg-white rounded-full animate-pulse"
           :style="{
             left: `${Math.random() * 100}%`,
             top: `${Math.random() * 100}%`
           }">
      </div>
    </div>

    <div class="relative z-10 flex flex-col items-center justify-center min-h-screen p-4 text-white">
      <div
        ref="logo"
        class="mb-12 transition-transform duration-300 transform hover:scale-105 draggable-logo"
        @mousedown="startDragging"
        @mousemove="onDrag"
        @mouseup="stopDragging"
        @mouseleave="stopDragging"
        :style="{ transform: `translate(${position.x}px, ${position.y}px)` }">
        <img
          :src="'/img/logo.png'"
          alt="Stramers Logo"
          draggable="false"
          class="object-contain w-64 h-64 border-4 border-purple-500 rounded-full shadow-lg select-none"
        />
      </div>

      <div class="flex flex-row flex-wrap justify-center w-full max-w-4xl gap-6 mb-8">
        <button @click="openModalPerfil" class="p-4 transition-colors border border-gray-600 shadow-md bg-gray-700/50 rounded-2xl backdrop-blur-lg hover:border-gray-500">
          <!-- <a :href="route('profile.show')" class="block mb-1 text-sm font-medium text-center text-gray-300">Profile</a> -->
           <img :src="$page.props.auth.user" class="h-full border rounded-full shadow-sm " alt="">
          <div class="px-4 py-2 font-bold text-white rounded-lg bg-gray-800/70">
            {{ $page.props.auth.user.name }}
          </div>
        </button>

        <div class="flex-1 min-w-[300px] bg-gray-800/30 rounded-3xl backdrop-blur-lg p-4 flex gap-4">
          <button @click="openModalGame" class="flex-1 px-6 py-3 text-lg font-bold text-center text-white transition-all duration-200 transform rounded-lg shadow-lg bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 hover:scale-105 hover:shadow-blue-500/50">
            PLAY
          </button>
          <button @click="$inertia.visit(route('deck'))" class="flex-1 px-6 py-3 text-lg font-bold text-center text-white transition-all duration-200 transform rounded-lg shadow-lg bg-gradient-to-r from-green-600 to-teal-600 hover:from-green-500 hover:to-teal-500 hover:scale-105 hover:shadow-green-500/50">
            COLLECTION
          </button>
          <button @click="$inertia.visit(route('shop'))" class="flex-1 px-6 py-3 text-lg font-bold text-center text-white transition-all duration-200 transform rounded-lg shadow-lg bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-500 hover:to-pink-500 hover:scale-105 hover:shadow-purple-500/50">
            Tienda
          </button>
        </div>

        <div class="flex flex-col gap-4">
          <button @click="openModalConfig" class="px-6 py-3 font-bold text-white transition-all duration-200 transform rounded-lg shadow-lg bg-gradient-to-r from-orange-500 to-yellow-500 hover:from-orange-400 hover:to-yellow-400 hover:scale-105 hover:shadow-orange-500/50">
            OPTIONS
          </button>
          <Link :href="route('logout')" method="post" as="button"
                class="px-6 py-3 font-bold text-white transition-all duration-200 transform rounded-lg shadow-lg bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-500 hover:to-rose-500 hover:scale-105 hover:shadow-red-500/50">
            QUIT
          </Link>
        </div>
      </div>

      <div class="flex gap-4">
        <button class="px-6 py-2 text-white transition-all duration-200 transform bg-gray-700 rounded-full shadow-md hover:bg-gray-600 hover:scale-105">
          Lang
        </button>
        <button class="px-6 py-2 text-white transition-all duration-200 transform bg-blue-600 rounded-full shadow-md hover:bg-blue-500 hover:scale-105">
          Discord
        </button>
        <button class="px-6 py-2 text-white transition-all duration-200 transform rounded-full shadow-md bg-sky-500 hover:bg-sky-400 hover:scale-105">
          Twitter
        </button>
      </div>
    </div>

    <div class="absolute inset-0 z-0 pointer-events-none">
      <div
        v-for="i in 100"
        :key="i"
        class="absolute w-2 h-2 bg-white rounded-full animate-floating-star"
        :style="{
          left: `${Math.random() * 100}%`,
          top: `${Math.random() * 100}%`,
          animationDelay: `${Math.random() * 5}s`
        }"
      ></div>
    </div>

    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div v-for="i in 8" :key="`card-${i}`"
           class="absolute w-20 h-32 rounded-lg shadow-md bg-white/5"
           :style="{
             left: `${Math.random() * 100}%`,
             top: `${Math.random() * 100}%`,
             transform: `rotate(${Math.random() * 360}deg)`,
             animation: `float ${5 + Math.random() * 5}s infinite ease-in-out`
           }">
      </div>
    </div>
    <SelectGameModal
      v-if="isModalOpenGame"
      :selected-deck="selectedDeck"
      :selected-mode="selectedMode"
      @close="closeModalGame"
      @start="startGame"
      @update:selected-deck="selectedDeck = $event"
      @update:selected-mode="selectedMode = $event"
    ></SelectGameModal>

    <ConfigModal
      :show="isModalOpenConfig"
      @close="closeModalConfig"
    ></ConfigModal>

    <PerfilModal
      :show="isModalOpenPerfil"
      @close="closeModalPerfil"
    ></PerfilModal>
  </div>
</template>

<script>
import SelectGameModal from '@/Components/Modal/SelectGameModal.vue';
import ConfigModal from '@/Components/Modal/ConfigModal.vue';
import PerfilModal from '@/Components/Modal/PerfilModal.vue';
import { Link } from '@inertiajs/vue3';

export default {
  name: 'HomePage',
  components: {
    SelectGameModal,
    ConfigModal,
    PerfilModal,
    Link,
  },
  data(){
    return{
      isModalOpenGame: false,
      isModalOpenConfig: false,
      isModalOpenPerfil: false,
      selectedDeck: null,
      selectedMode: 'casual',

      isDragging: false,
      startPosition: { x: 0, y: 0 },
      position: { x: 0, y: 0 },
      offset: { x: 0, y: 0 },
    }
  },
  methods: {
    openModalGame() {
      this.isModalOpenGame = true;
    },
    closeModalGame() {
      this.isModalOpenGame = false;
    },
    startGame() {
      if (!this.selectedDeck) {
        console.log('selecciona un mazo.');
        return;
      }
      console.log(`Buscando partida con:\nMazo: ${this.decks.find(deck => deck.id === this.selectedDeck).name}\nModo: ${this.selectedMode}`);
      // Aquí puedes redirigir a la pantalla de búsqueda de partida o iniciar la lógica del juego.
      this.closeModalGame();
    },
    openModalConfig() {
      this.isModalOpenConfig = true;
    },
    closeModalConfig() {
      this.isModalOpenConfig = false;
    },
    openModalPerfil() {
      this.isModalOpenPerfil = true;
    },
    closeModalPerfil() {
      this.isModalOpenPerfil = false;
    },

    startDragging(event) {
      this.isDragging = true;
      this.startPosition = { x: event.clientX, y: event.clientY };
      this.offset = {
        x: this.position.x - event.clientX,
        y: this.position.y - event.clientY,
      };
    },
    onDrag(event) {
      if (!this.isDragging) return;

      const deltaX = event.clientX + this.offset.x;
      const deltaY = event.clientY + this.offset.y;

      // Limitar el movimiento dentro de los límites de la pantalla
      const bounds = this.$refs.logo.getBoundingClientRect();
      const parentBounds = this.$refs.logo.parentElement.getBoundingClientRect();

      const maxX = parentBounds.width - bounds.width;
      const maxY = parentBounds.height - bounds.height;

      this.position.x = Math.max(0, Math.min(deltaX, maxX));
      this.position.y = Math.max(0, Math.min(deltaY, maxY));
    },
    stopDragging() {
      this.isDragging = false;

      // Animar el regreso a la posición original si se movió mucho
      if (Math.abs(this.position.x) > 100 || Math.abs(this.position.y) > 100) {
        this.returnToOriginalPosition();
      }
    },
    returnToOriginalPosition() {
      this.position.x = 0;
      this.position.y = 0;
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

.animate-floating-star {
  animation: floating-star 6s ease-in-out infinite;
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

.draggable-logo {
  transition: transform 0.5s ease-out;
  cursor: grab;
  user-select: none;
}

.draggable-logo:active {
  cursor: grabbing;
}

.draggable-logo img {
  pointer-events: none; /* Evita la interacción directa con la imagen */
}
</style>
