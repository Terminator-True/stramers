<template>
    <div
      class="relative w-64 overflow-hidden transition-transform duration-300 transform border border-black rounded-lg shadow-xl h-96 hover:scale-105"
    >
      <!-- Imagen de fondo o placeholder -->
      <div
        v-if="card.img"
        class="absolute inset-0 w-full h-full"
        :style="{ backgroundImage: `url(${'/storage/cards/' + card.img})`, backgroundSize: 'cover', backgroundPosition: 'center' }"
      ></div>
      <div
        v-else
        class="absolute inset-0 flex flex-col items-center justify-center w-full h-full bg-gray-700"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mb-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        <span class="text-sm text-gray-400">Sin imagen</span>
      </div>
      <!-- Overlay para oscurecer la imagen y mejorar legibilidad -->
      <div class="absolute inset-0 bg-black bg-opacity-30"></div>

      <!-- Nombre de la carta -->
      <div class="absolute z-10 text-2xl font-bold text-white top-4 left-12">
        {{ card.name }}
      </div>

      <!-- Categoría y Tipo -->
      <div class="absolute z-10 flex flex-col items-end top-4 right-4">
        <span class="text-sm font-semibold text-gray-300">{{ card.category }}</span>
        <span class="text-sm font-semibold text-gray-300">{{ card.type }}</span>
      </div>

      <!-- Costo -->
      <div class="absolute z-10 px-2 py-1 text-white rounded-full top-4 left-4 bg-gray-800/50">
        <span class="text-sm font-bold">{{ card.cost }}</span>
      </div>

      <!-- Texto descriptivo -->
      <div class="absolute z-10 text-sm text-center text-white bottom-32 left-4 right-4">
        <p class="break-words">{{ card.text }}</p>
      </div>

      <!-- Estadísticas -->
      <div class="absolute z-10 flex gap-2 bottom-4 left-4">
        <div class="px-2 py-1 text-white rounded-md bg-gray-800/50">
          <span class="font-bold">DMG: {{ card.dmg }}</span>
        </div>
        <div class="px-2 py-1 text-white rounded-md bg-gray-800/50">
          <span class="font-bold">LIFE: {{ card.life }}</span>
        </div>
        <div class="px-2 py-1 text-white rounded-md bg-gray-800/50">
          <span class="font-bold">USES: {{ card.usos }}</span>
        </div>
      </div>

      <!-- Raridad -->
      <div class="absolute bottom-0 left-0 right-0 z-10 flex items-center justify-center h-8 bg-opacity-50" :class="rarityColor(card.rarity)">
        <span class="text-sm font-bold text-white">{{ card.rarity }}</span>
      </div>
    </div>
  </template>

<script>
export default {
  props: {
    card: {
      type: Object,
      required: true,
    },
  },
  methods: {
    rarityColor(rarity) {
      switch (rarity) {
        case "Common":
          return "bg-green-500";
        case "Rare":
          return "bg-blue-500";
        case "Epic":
          return "bg-purple-500";
        case "Legendary":
          return "bg-gold-500";
        default:
          return "bg-gray-500";
      }
    },
  },
  mounted(){
    console.log(this.card)
  },

};
</script>

<style>
.card-overlay {
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.4);
  border: 2px solid rgba(255, 255, 255, 0.2);
  backdrop-filter: blur(10px);
}
</style>
