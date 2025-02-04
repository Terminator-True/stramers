<template>
   <!-- Modal -->
   <div class="fixed inset-0 bg-black/70 flex items-center justify-center z-50">
      <div class="bg-gray-800/90 backdrop-blur-lg rounded-lg p-6 w-full max-w-2xl text-white shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600">
          Configuración de Partida
        </h2>

        <!-- Deck Selection -->
        <div class="mb-6">
          <label class="block text-lg font-semibold mb-2">Elige tu Mazo:</label>
          <select v-model="selectedDeck" class="w-full px-4 py-2 bg-gray-700/50 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500">
            <option v-for="deck in decks" :key="deck.id" :value="deck.id">{{ deck.name }}</option>
          </select>
        </div>

        <!-- Game Mode Selection -->
        <div class="mb-6">
          <label class="block text-lg font-semibold mb-2">Elige el Modo de Juego:</label>
          <select v-model="selectedMode" class="w-full px-4 py-2 bg-gray-700/50 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500">
            <option value="casual">Casual</option>
            <option value="ranked">Clasificatoria</option>
            <option value="custom">Personalizado</option>
          </select>
        </div>

        <!-- Play Button -->
        <button @click="startGame" class="w-full px-6 py-3 bg-gradient-to-r from-green-500 to-teal-500 hover:from-green-400 hover:to-teal-400 text-white font-bold rounded-lg shadow-md transform hover:scale-105 transition-all duration-200">
          Jugar
        </button>

        <!-- Close Modal Button -->
        <button @click="closeModal" class="mt-4 w-full px-6 py-2 bg-red-600 hover:bg-red-500 text-white font-bold rounded-lg shadow-md transform hover:scale-105 transition-all duration-200">
          Cerrar
        </button>
      </div>
    </div>
</template>

<script>
export default {

}
</script>

<style>

</style>