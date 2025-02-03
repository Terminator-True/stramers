<template>
    <div class="container mx-auto p-4">
      <a :href="route('dashboard')" class="mb-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        &larr; 
      </a>
  
      <h2 class="text-2xl font-bold mb-4">Decks</h2>
  
      <ul class="space-y-2 mb-8">
        <li v-for="deck in decks" :key="deck.id" class="bg-gray-100 p-3 rounded shadow">
          {{ deck.name }}
        </li>
      </ul>
  
      <div class="bg-gray-200 p-4 rounded">
        <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            Create New Deck
        </button>
      </div>
    </div>
  </template>
  
  <script>
  export default {

    props: [
      'decks',
    ],
    data() {
      return {
        newDeckName: ""
      };
    },
    methods: {
      
    }
  };
  </script>
  