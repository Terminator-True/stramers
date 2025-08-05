<template>
  <div class="relative min-h-screen overflow-hidden bg-gradient-to-br from-gray-900 via-purple-950 to-black">


    <!-- Main content -->
    <div class="relative z-10 flex flex-col items-center justify-center min-h-screen p-4 text-white">
      <!-- Header -->
      <h1 class="mb-8 text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600">
        Tienda de Cartas
      </h1>

      <!-- Sobres Section -->
      <div class="w-full max-w-4xl p-6 mb-8 rounded-lg shadow-md bg-gray-800/50 backdrop-blur-lg">
        <h2 class="mb-4 text-2xl font-semibold text-purple-400">Sobres de Cartas</h2>
        <div class="flex justify-around gap-4">
          <div v-for="pack in packs" :key="pack.type" class="flex flex-col items-center gap-2">
            <button @click="buyPack(pack.type)" class="w-32 h-32 transition-all duration-200 transform rounded-lg shadow-md bg-gradient-to-b from-blue-600 to-indigo-700 hover:from-blue-500 hover:to-indigo-600 hover:scale-105">
              <span class="text-xl font-bold text-white">{{ pack.name }}</span>
            </button>
            <p class="text-gray-400">{{ pack.price }} Coins</p>
          </div>
        </div>
      </div>

      <button @click="$inertia.visit(route('dashboard'))" class="absolute flex items-center gap-2 px-6 py-3 font-bold text-white transition-all duration-200 transform rounded-lg shadow-lg top-6 left-6 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 hover:scale-105">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        <!-- Volver al Menú -->
      </button>

      <!-- Ruleta Section -->
      <div class="w-full max-w-4xl p-6 mb-8 rounded-lg shadow-md bg-gray-800/50 backdrop-blur-lg">
        <h2 class="mb-4 text-2xl font-semibold text-purple-400">Ruleta de Cartas</h2>
        <div class="flex flex-col items-center gap-4">
          <div class="relative w-64 h-64">
            <canvas ref="wheelCanvas" width="256" height="256" class="rounded-full shadow-md"></canvas>
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
              <span class="text-2xl font-bold text-white">{{ spinning ? '...' : 'GIRAR' }}</span>
            </div>
            <div class="absolute -translate-x-1/2 -translate-y-full top-1/2 left-1/2">
              <svg width="32" height="32" viewBox="0 0 32 32"><polygon points="16,0 24,16 8,16" fill="#fff"/></svg>
            </div>
          </div>
          <button @click="spinWheel" :disabled="spinning" class="px-6 py-2 font-bold text-white transition-all duration-200 transform rounded-lg shadow-md bg-gradient-to-r from-green-500 to-teal-500 hover:from-green-400 hover:to-teal-400 hover:scale-105 disabled:opacity-50">
            Girar Ruleta (50 Coins)
          </button>
          <div v-if="resultRarity" class="mt-4 text-xl font-bold" :class="rarityColorClass(resultRarity)">
            ¡Obtuviste una carta <span>{{ resultRarity }}</span>!
          </div>
        </div>
      </div>

      <!-- Tienda de Cartas Individuales -->
      <div class="w-full max-w-4xl p-6 rounded-lg shadow-md bg-gray-800/50 backdrop-blur-lg">
        <h2 class="mb-4 text-2xl font-semibold text-purple-400">Cartas Individuales</h2>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
          <div v-for="card in cards" :key="card.id" class="flex flex-col items-center gap-2 p-4 rounded-lg shadow-md bg-gray-700/50 backdrop-blur-lg">
            <Card :card="card" />
            <p class="text-gray-400">{{ card.price ? card.price + ' Coins' : '' }}</p>
            <button @click="buyCard(card.id)" class="px-4 py-2 font-bold text-white transition-all duration-200 transform rounded-lg shadow-sm bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-400 hover:to-indigo-500 hover:scale-105">
              Comprar
            </button>
          </div>
        </div>
      </div>

      <Card v-if="card && card.img" :card="card" class="mt-10" />

    </div>



  </div>
</template>

<script setup>
import { ref, onMounted, nextTick } from 'vue';
// Ruleta config
const wheelCanvas = ref(null);
const spinning = ref(false);
const resultRarity = ref('');
const wheelSectors = [
  { label: 'legendary', color: '#FFD700', probability: 1 },   // 1%
  { label: 'epic', color: '#8B5CF6', probability: 4 },        // 4%
  { label: 'normal', color: '#60A5FA', probability: 30 },     // 30%
  { label: 'common', color: '#A3E635', probability: 65 },     // 65%
];

function getWheelSlices() {
  // Devuelve un array de sectores repetidos según la probabilidad (para simular la ruleta)
  const slices = [];
  wheelSectors.forEach(s => {
    for (let i = 0; i < s.probability; i++) {
      slices.push(s);
    }
  });
  return slices;
}

function drawWheel(angle = 0) {
  const canvas = wheelCanvas.value;
  if (!canvas) return;
  const ctx = canvas.getContext('2d');
  const size = canvas.width;
  const slices = getWheelSlices();
  const n = slices.length;
  ctx.clearRect(0, 0, size, size);
  const center = size / 2;
  let startAngle = angle;
  for (let i = 0; i < n; i++) {
    const slice = slices[i];
    const sliceAngle = (2 * Math.PI) / n;
    ctx.save();
    ctx.beginPath();
    ctx.moveTo(center, center);
    ctx.arc(center, center, center, startAngle, startAngle + sliceAngle, false);
    ctx.closePath();
    ctx.fillStyle = slice.color;
    ctx.fill();
    ctx.restore();
    startAngle += sliceAngle;
  }
}

onMounted(() => {
  drawWheel();
});

function rarityColorClass(rarity) {
  if (rarity === 'legendary') return 'text-yellow-400';
  if (rarity === 'epic') return 'text-purple-400';
  if (rarity === 'normal') return 'text-blue-400';
  if (rarity === 'common') return 'text-lime-400';
  return '';
}

async function spinWheel() {
  if (spinning.value) return;
  spinning.value = true;
  resultRarity.value = '';
  const slices = getWheelSlices();
  const n = slices.length;
  // Elegir resultado aleatorio según probabilidad
  const resultIndex = Math.floor(Math.random() * n);
  const result = slices[resultIndex];
  // Animación de giro
  let angle = 0;
  let spins = 6 + Math.random() * 2; // vueltas completas
  const finalAngle = (2 * Math.PI * spins) + (2 * Math.PI * (resultIndex / n));
  const duration = 2200;
  const start = performance.now();
  function animate(now) {
    const elapsed = now - start;
    const t = Math.min(elapsed / duration, 1);
    // Ease out cubic
    const eased = 1 - Math.pow(1 - t, 3);
    angle = eased * finalAngle;
    drawWheel(angle);
    if (t < 1) {
      requestAnimationFrame(animate);
    } else {
      // Mostrar resultado
      resultRarity.value = result.label;
      spinning.value = false;
    }
  }
  requestAnimationFrame(animate);
}
import Card from '@/Components/Cards/Card.vue';
import axios from 'axios';
import MainLayout from '@/Layouts/MainLayout.vue';

defineOptions({ layout: MainLayout });

const cards = ref([]);

onMounted(async () => {
    await getRandomCards();
});

function buyCard(cardId) {
  // Implementa aquí la lógica de compra
  alert('Comprar carta con id: ' + cardId);
}

async function getRandomCards() {
   try {
    const response = await axios.get(route('shop.randomCards'));
    if (response.data && response.data.cards) {
      cards.value = response.data.cards;
    }
  } catch (e) {
    console.error('Error al obtener cartas aleatorias:', e);
  }
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
