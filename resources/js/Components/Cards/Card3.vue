<template>
    <div class="relative w-64 h-96 rounded-lg overflow-hidden border-4 border-yellow-500 shadow-xl transform hover:scale-105 transition-transform duration-300">
        
        
        <!-- Imagen de fondo -->
        <img :src="'/storage/cards/' + card.img" alt="Card Image" class="absolute inset-0 w-full h-full object-cover">
        
        <!-- Fondo degradado -->
        <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-purple-900/10 to-black opacity-75"></div>
        
        <!-- Brillo sobre la imagen -->
        <!-- <div class="absolute inset-0 bg-white/10 backdrop-blur-xs"></div> -->
  
      <!-- Costo en la esquina superior izquierda -->
      <div class="absolute top-2 left-2 bg-blue-600 text-white font-bold text-xl w-10 h-10 flex items-center justify-center rounded-full border-2 border-white shadow-lg">
        {{ card.cost }}
      </div>
  
      <!-- Rareza en la esquina superior derecha -->
        <!-- <div class="absolute top-2 right-2 bg-gray-800 text-yellow-400 font-semibold px-2 py-1 rounded-md text-xs border border-yellow-400">
            {{ card.rarity }}
        </div> -->

      <div class="absolute top-2 right-2 px-2 py-1 rounded-md text-xs font-semibold flex items-center gap-1 shadow-md"
           :class="rarityColor(card.rarity)">
        <span>{{ card.rarity }}</span>
        <span class="w-2 h-2 rounded-full" :class="rarityDotColor(card.rarity)"></span>
      </div>
  
      <!-- Contenido principal -->
      <div class="absolute bottom-0 w-full bg-black bg-opacity-80 p-4">
        <h2 class="text-white text-lg font-bold text-center uppercase mb-2">{{ card.name }}</h2>
        <p class="text-gray-400 text-sm text-center mb-4">{{ card.category }} - {{ card.type }}</p>
  
        <!-- Atributos -->
        <div class="flex justify-between items-center mb-4">
          <div class="flex items-center bg-orange-500 px-3 py-1 rounded-lg text-white font-bold shadow-md">
            <span class="text-xl">⚔️</span> <span class="ml-1">{{ card.dmg }}</span>
          </div>
          <div class="flex items-center bg-red-600 px-3 py-1 rounded-lg text-white font-bold shadow-md">
            <span class="text-xl">❤️</span> <span class="ml-1">{{ card.life }}</span>
          </div>
        </div>
  
        <!-- Descripción -->
        <p class="text-gray-300 text-sm italic leading-relaxed">{{ card.text }}</p>
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
        switch (rarity.toLowerCase()) {
          case "common":
            return "bg-green-500 text-white";
          case "rare":
            return "bg-blue-500 text-white";
          case "epic":
            return "bg-purple-500 text-white";
          case "legendary":
            return "bg-gold-500 text-black";
          default:
            return "bg-gray-500 text-white";
        }
      },
      rarityDotColor(rarity) {
        switch (rarity.toLowerCase()) {
          case "common":
            return "bg-green-500";
          case "rare":
            return "bg-blue-500";
          case "epic":
            return "bg-purple-500";
          case "legendary":
            return "bg-gold-500";
          default:
            return "bg-gray-500";
        }
      },
    },
  };
  </script>
  
  <style scoped>
  /* Efecto de brillo */
  .bg-white\/10 {
    background-color: rgba(255, 255, 255, 0.1);
  }
  
  /* Transición suave */
  .transform {
    transition: transform 0.3s ease-in-out;
  }
  
  /* Hover effect */
  .hover\:scale-105:hover {
    scale: 1.05;
  }
  
  /* Gradient overlay */
  .bg-gradient-to-br {
    background-size: 200% 200%;
    animation: gradient-shimmer 3s infinite;
  }
  
  @keyframes gradient-shimmer {
    0% {
      background-position: 0% 50%;
    }
    100% {
      background-position: 100% 50%;
    }
  }
  </style>