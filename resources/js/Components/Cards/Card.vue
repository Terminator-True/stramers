<template>
    <div
      class="relative w-64 h-96 border border-black rounded-lg shadow-xl overflow-hidden transform hover:scale-105 transition-transform duration-300"
      :style="{ backgroundImage: `url(${card.img})`, backgroundSize: 'cover', backgroundPosition: 'center' }"
    >
      <!-- Nombre de la carta -->
      <div class="absolute top-4 left-4 text-white font-bold text-2xl z-10">
        {{ card.name }}
      </div>
  
      <!-- Categoría y Tipo -->
      <div class="absolute top-4 right-4 flex flex-col items-end z-10">
        <span class="text-sm text-gray-300 font-semibold">{{ card.category }}</span>
        <span class="text-sm text-gray-300 font-semibold">{{ card.type }}</span>
      </div>
  
      <!-- Costo -->
      <div class="absolute top-4 left-4 bg-gray-800/50 text-white rounded-full px-2 py-1 z-10">
        <span class="text-sm font-bold">{{ card.cost }}</span>
      </div>
  
      <!-- Texto descriptivo -->
      <div class="absolute bottom-32 left-4 right-4 text-white text-center text-sm z-10">
        <p class="break-words">{{ card.text }}</p>
      </div>
  
      <!-- Estadísticas -->
      <div class="absolute bottom-4 left-4 flex gap-2 z-10">
        <div class="bg-gray-800/50 text-white rounded-md px-2 py-1">
          <span class="font-bold">DMG: {{ card.dmg }}</span>
        </div>
        <div class="bg-gray-800/50 text-white rounded-md px-2 py-1">
          <span class="font-bold">LIFE: {{ card.life }}</span>
        </div>
        <div class="bg-gray-800/50 text-white rounded-md px-2 py-1">
          <span class="font-bold">USES: {{ card.usos }}</span>
        </div>
      </div>
  
      <!-- Raridad -->
      <div class="absolute bottom-0 left-0 right-0 h-8 bg-opacity-50 flex items-center justify-center z-10" :class="rarityColor(card.rarity)">
        <span class="text-white font-bold text-sm">{{ card.rarity }}</span>
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