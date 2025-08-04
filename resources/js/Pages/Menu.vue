<template>
  <!-- El fondo ahora está en el layout -->
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

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import SelectGameModal from '@/Components/Modal/SelectGameModal.vue';
import ConfigModal from '@/Components/Modal/ConfigModal.vue';
import PerfilModal from '@/Components/Modal/PerfilModal.vue';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

// Cambia defineOptions por la sintaxis defineProps/defineEmits y export default para layout
defineOptions({ layout: MainLayout });

const props = defineProps({
  auth: Object,
});

defineEmits(['close']);

let isModalOpenGame = ref(false);
let isModalOpenConfig = ref(false);
let isModalOpenPerfil = ref(false);
let selectedDeck = ref(null);
let selectedMode = ref('casual');

let isDragging = ref(false);
let startPosition = ref({ x: 0, y: 0 });
let position = ref({ x: 0, y: 0 });
let offset = ref({ x: 0, y: 0 });

function openModalGame() {
  isModalOpenGame.value = true;
}

function closeModalGame() {
  isModalOpenGame.value = false;
}

function startGame() {
  if (!selectedDeck.value) {
    console.log('selecciona un mazo.');
    return;
  }
  console.log(`Buscando partida con:\nMazo: ${props.decks.find(deck => deck.id === selectedDeck.value).name}\nModo: ${selectedMode.value}`);
  closeModalGame();
}

function openModalConfig() {
  isModalOpenConfig.value = true;
}

function closeModalConfig() {
  isModalOpenConfig.value = false;
}

function openModalPerfil() {
  isModalOpenPerfil.value = true;
}

function closeModalPerfil() {
  isModalOpenPerfil.value = false;
}

function startDragging(event) {
  isDragging.value = true;
  startPosition.value = { x: event.clientX, y: event.clientY };
  offset.value = {
    x: position.value.x - event.clientX,
    y: position.value.y - event.clientY,
  };
}

function onDrag(event) {
  if (!isDragging.value) return;

  const deltaX = event.clientX + offset.value.x;
  const deltaY = event.clientY + offset.value.y;

  const bounds = $refs.logo.getBoundingClientRect();
  const parentBounds = $refs.logo.parentElement.getBoundingClientRect();

  const maxX = parentBounds.width - bounds.width;
  const maxY = parentBounds.height - bounds.height;

  position.value.x = Math.max(0, Math.min(deltaX, maxX));
  position.value.y = Math.max(0, Math.min(deltaY, maxY));
}

function stopDragging() {
  isDragging.value = false;

  if (Math.abs(position.value.x) > 100 || Math.abs(position.value.y) > 100) {
    returnToOriginalPosition();
  }
}

function returnToOriginalPosition() {
  position.value.x = 0;
  position.value.y = 0;
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

</style>
