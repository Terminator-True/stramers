<template>
    <div class="min-h-screen bg-gray-900 text-white p-4 pt-20 ">
        <button @click="$inertia.visit(route('dashboard'))" class="absolute top-6 left-6 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </button>
        <!-- Encabezado -->
        <h1 class="text-3xl font-bold mb-6">Creador de Mazos</h1>
  
      <!-- Filtros -->
      <div class="mb-6">
        <h2 class="text-xl font-semibold mb-2">Filtrar Cartas</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <div>
            <label class="block mb-1">Nombre:</label>
            <input v-model="filters.name" type="text" placeholder="Buscar por nombre" class="w-full bg-gray-800 rounded-md px-3 py-2" />
          </div>
          <div>
            <label class="block mb-1">Raridad:</label>
            <select v-model="filters.rarity" class="w-full bg-gray-800 rounded-md px-3 py-2">
              <option value="">Todas</option>
              <option value="Common">Común</option>
              <option value="Rare">Rara</option>
              <option value="Epic">Épica</option>
              <option value="Legendary">Legendaria</option>
            </select>
          </div>
          <div>
            <label class="block mb-1">Costo:</label>
            <input v-model.number="filters.cost" type="number" placeholder="Costo" class="w-full bg-gray-800 rounded-md px-3 py-2" />
          </div>
          <div>
            <label class="block mb-1">Daño:</label>
            <input v-model.number="filters.dmg" type="number" placeholder="Daño" class="w-full bg-gray-800 rounded-md px-3 py-2" />
          </div>
          <div>
            <label class="block mb-1">Vida:</label>
            <input v-model.number="filters.hp" type="number" placeholder="Vida" class="w-full bg-gray-800 rounded-md px-3 py-2" />
          </div>
          <div>
            <label class="block mb-1">Tipo:</label>
            <select v-model="filters.type" class="w-full bg-gray-800 rounded-md px-3 py-2">
              <option value="">Todos</option>
              <option value="Spell">Hechizo</option>
              <option value="Enchantment">Encantamiento</option>
              <option value="Creature">Criatura</option>
            </select>
          </div>
          <div>
            <label class="block mb-1">Usos:</label>
            <input v-model.number="filters.usos" type="number" placeholder="Usos" class="w-full bg-gray-800 rounded-md px-3 py-2" />
          </div>
        </div>
      </div>
  
      <!-- Lista de Cartas -->
      <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <div
          v-for="card in filteredCards"
          :key="card.id"
          class="bg-gray-800/50 rounded-lg p-4 shadow-lg hover:scale-105 transition-transform duration-300 cursor-pointer"
          @click="addCardToDeck(card)"
        >

          <Card2 :card="card" />

        </div>
      </div>
  
      <!-- Constructor de Mazo -->
      <div class="mt-8">
        <h2 class="text-xl font-semibold mb-4">Mazo Actual</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
          <div
            v-for="(count, cardId) in deck"
            :key="cardId"
            class="bg-gray-700 rounded-lg p-4 shadow-lg flex items-center justify-between"
          >
            <div>
              <h3 class="text-lg font-bold">{{ getCardById(cardId).name }}</h3>
              <p class="text-sm text-gray-400">{{ getCardById(cardId).category }} - {{ getCardById(cardId).type }}</p>
            </div>
            <div class="flex items-center space-x-2">
              <button @click="removeCardFromDeck(cardId)" class="text-red-500 hover:text-red-400">-</button>
              <span>{{ count }}</span>
              <button @click="addCardToDeck(getCardById(cardId))" class="text-green-500 hover:text-green-400">+</button>
            </div>
          </div>
        </div>
  
        <button
          @click="createDeck"
          class="mt-6 bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 px-6 rounded-lg w-full"
        >
          Crear Mazo
        </button>
      </div>
    </div>
  </template>

<script>
import axios from 'axios';
import Card from '@/Components/Cards/Card.vue';
import Card2 from '@/Components/Cards/Card2.vue';
import Card3 from '@/Components/Cards/Card3.vue';



export default {
    components:{
        Card, Card2, Card3
    },
  data() {
    return {
      cards: [],
      filters: {
        name: "",
        rarity: "",
        cost: null,
        dmg: null,
        hp: null,
        type: "",
        usos: null,
      },
      deck: {}, // Mazo actual (clave: ID de carta, valor: cantidad)
    };
  },
  computed: {
    filteredCards() {
      return this.cards.filter((card) => {
        return (
          (!this.filters.name || card.name.toLowerCase().includes(this.filters.name.toLowerCase())) &&
          (!this.filters.rarity || card.rarity === this.filters.rarity) &&
          (!this.filters.cost || card.cost === this.filters.cost) &&
          (!this.filters.dmg || card.dmg === this.filters.dmg) &&
          (!this.filters.hp || card.life === this.filters.hp) &&
          (!this.filters.type || card.type === this.filters.type) &&
          (!this.filters.usos || card.usos === this.filters.usos)
        );
      });
    },
  },
  mounted(){
    this.getCardAll();
  },
  methods: {
    getCardAll() {
      axios.get(route('carta.all'))
        .then(response => {
            console.log(response.data);
          this.cards = response.data.value;
        })
        .catch(error => {
          console.error('Error fetching cards:', error);
        });
    },
    addCardToDeck(card) {
      if (this.deck[card.id]) {
        if (this.deck[card.id] >= card.usos) return; // No permitir más de la cantidad máxima
        this.deck[card.id]++;
      } else {
        this.deck[card.id] = 1;
      }
    },
    removeCardFromDeck(cardId) {
      if (this.deck[cardId] && this.deck[cardId] > 1) {
        this.deck[cardId]--;
      } else {
        delete this.deck[cardId];
      }
    },
    getCardById(id) {
      return this.cards.find((card) => card.id === id);
    },
    createDeck() {
      alert("Mazo creado!");
      console.log("Mazo:", this.deck);
    },
  },
};
</script>