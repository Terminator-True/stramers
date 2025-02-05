<template>
    <div class="relative w-[300px] select-none">
      <!-- Card Container with gradient border -->
      <div class="relative rounded-2xl overflow-hidden transform transition-transform hover:scale-105">
        <!-- Gradient Border -->
        <div class="absolute inset-0 bg-gradient-to-b from-blue-400 via-purple-500 to-orange-500 rounded-2xl p-[2px]">
          <!-- Main Card Body -->
          <div class="relative bg-gradient-to-b from-gray-800 to-gray-900 rounded-2xl overflow-hidden h-[420px]">
            <!-- Mana Cost -->
            <div class="absolute top-2 left-2 w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center z-10">
              <span class="text-2xl font-bold text-white">{{ card.cost }}</span>
            </div>
            
            <!-- Region Icon -->
            <div class="absolute top-2 right-2 w-10 h-10 bg-gray-800 rounded-lg z-10">
              <!-- <img :src="card.regionIcon" alt="Region" class="w-full h-full object-contain p-1" /> -->
              <span class="text-sm text-white">{{ card.category }}</span>
            </div>
  
            <!-- Card Art -->
            <div class="w-full h-[230px] relative overflow-hidden">
              <!-- <img :src="'/storage/' + card.img" :alt="card.name" class="w-full h-full object-cover" /> -->
              <!-- Darkening Overlay -->
              <div class="absolute inset-0 bg-gradient-to-t from-gray-900 opacity-40"></div>
            </div>
  
            <!-- Card Content -->
            <div class="p-4 relative">
              <!-- Card Name -->
              <h2 class="text-white text-xl font-bold mb-2">{{ card.name }}</h2>
  
              <!-- Type and Uses -->
              <div class="mb-2 flex gap-2">
                <span class="bg-gradient-to-r from-orange-500 to-yellow-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                  {{ card.type }}
                </span>
                <span class="bg-gradient-to-r from-blue-500 to-purple-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                  Uses: {{ card.usos }}
                </span>
              </div>
  
              <!-- Card Description -->
              <p class="text-gray-300 text-sm mb-4 min-h-[60px]">{{ card.text }}</p>
  
              <!-- Stats Container -->
              <div class="absolute bottom-4 left-0 w-full flex justify-between px-6">
                <!-- Attack -->
                <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-red-600 rounded-lg flex items-center justify-center">
                  <span class="text-white font-bold text-xl">{{ card.dmg }}</span>
                </div>
                
                <!-- Health -->
                <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-700 rounded-lg flex items-center justify-center">
                  <span class="text-white font-bold text-xl">{{ card.life }}</span>
                </div>
              </div>
            </div>
  
            <!-- Rarity Gem -->
            <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 -mb-1">
              <div class="w-4 h-4" :class="{
                'bg-green-500': card.rarity === 'Common',
                'bg-blue-500': card.rarity === 'Rare',
                'bg-purple-500': card.rarity === 'Epic',
                'bg-yellow-500': card.rarity === 'Legendary'
              }" style="transform: rotate(45deg)"></div>
            </div>
          </div>
        </div>
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
    mounted() {
      // Esto te mostrará en la consola del navegador exactamente qué propiedades tiene el objeto card
      // console.log('Card2 received:', JSON.stringify(this.card, null, 2));
    },
  };
  </script>
  
  <style scoped>
  /* Add smooth transition for hover effects */
  .transform {
    transition: all 0.3s ease-in-out;
  }
  
  /* Add subtle shadow */
  .rounded-2xl {
    box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.3);
  }
  </style>