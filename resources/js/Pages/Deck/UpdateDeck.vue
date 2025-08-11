<template>
  <div class="min-h-screen p-4 pt-20 text-white bg-gray-900">
    <button @click="goToDeck" class="absolute flex items-center gap-2 px-6 py-3 font-bold text-white transition-all duration-200 transform rounded-lg shadow-lg top-6 left-6 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 hover:scale-105">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
      </svg>
    </button>
    <!-- Encabezado -->
    <h1 class="mb-6 text-3xl font-bold">Editar Mazo</h1>

    <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
      <!-- Constructor de Mazo (Izquierda, 75%) -->
      <div class="md:col-span-3">
        <!-- Filtros -->
        <div class="mb-6">
          <h2 class="mb-2 text-xl font-semibold">Filtrar Cartas</h2>
          <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
            <div>
              <label class="block mb-1">Nombre:</label>
              <input v-model="filters.name" type="text" placeholder="Buscar por nombre" class="w-full px-3 py-2 bg-gray-800 rounded-md" />
            </div>
            <div>
              <label class="block mb-1">Raridad:</label>
              <select v-model="filters.rarity" class="w-full px-3 py-2 bg-gray-800 rounded-md">
                <option value="">Todas</option>
                <option value="Common">Común</option>
                <option value="Rare">Rara</option>
                <option value="Epic">Épica</option>
                <option value="Legendary">Legendaria</option>
              </select>
            </div>
            <div>
              <label class="block mb-1">Costo:</label>
              <input v-model.number="filters.cost" type="number" placeholder="Costo" class="w-full px-3 py-2 bg-gray-800 rounded-md" />
            </div>
            <div>
              <label class="block mb-1">Daño:</label>
              <input v-model.number="filters.dmg" type="number" placeholder="Daño" class="w-full px-3 py-2 bg-gray-800 rounded-md" />
            </div>
            <div>
              <label class="block mb-1">Vida:</label>
              <input v-model.number="filters.hp" type="number" placeholder="Vida" class="w-full px-3 py-2 bg-gray-800 rounded-md" />
            </div>
            <div>
              <label class="block mb-1">Tipo:</label>
              <select v-model="filters.type" class="w-full px-3 py-2 bg-gray-800 rounded-md">
                <option value="">Todos</option>
                <option value="Spell">Hechizo</option>
                <option value="Enchantment">Encantamiento</option>
                <option value="Creature">Criatura</option>
              </select>
            </div>
            <div>
              <label class="block mb-1">Usos:</label>
              <input v-model.number="filters.usos" type="number" placeholder="Usos" class="w-full px-3 py-2 bg-gray-800 rounded-md" />
            </div>
          </div>
        </div>

        <!-- Lista de Cartas -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4">
          <div
            v-for="card in filteredCards"
            :key="card.id"
            class="flex items-center justify-center"
          >
            <Card :card="card" @click="addCardToDeck(card)" />
          </div>
        </div>
      </div>

      <!-- Lista de Cartas Seleccionadas (Derecha, 25%) -->
      <div class="md:col-span-1">
        <h2 class="mb-4 text-xl font-semibold">Cartas Seleccionadas {{ totalCardsInDeck }}</h2>
        <div class="grid grid-cols-1 gap-4">
          <div
            v-for="cardItem in deck.filter(item => item && item.card)"
            :key="cardItem.card.id"
            class="flex items-center justify-between p-4 mb-2 bg-gray-700 rounded-lg shadow-lg"
          >
            <div>
              <h3 class="text-lg font-bold text-white">{{ cardItem.card.name }}</h3>
              <p class="text-sm text-gray-300">
                {{ cardItem.card.category }} - {{ cardItem.card.type }}
              </p>
            </div>
            <div class="flex items-center space-x-2">
              <button @click="removeCardFromDeck(cardItem.card.id)" class="text-red-300 hover:text-red-100">-</button>
              <span class="text-white">{{ cardItem.count }}</span>
              <button @click="addCardToDeck(cardItem.card)" class="text-green-300 hover:text-green-100">+</button>
            </div>
          </div>
        </div>
        <!-- Botón Actualizar Mazo -->
        <button
          @click="updateDeck"
          class="w-full px-6 py-3 mt-6 font-bold text-white bg-green-600 rounded-lg hover:bg-green-500"
        >
          Actualizar Mazo
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Card from '@/Components/Cards/Card.vue';

export default {
  components: {
    Card,
  },
  props: {
    deckProp: {
      type: Object,
      required: true,
    },
    cards: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      filters: {
        name: "",
        rarity: "",
        cost: null,
        dmg: null,
        hp: null,
        type: "",
        usos: null,
      },
      deck: [],
      rarityLimits: {
        Legendary: 2,
        Epic: 4,
        Rare: 8,
        Common: Infinity,
      },
      deck_to_request: [],
    };
  },
  computed: {
    filteredCards() {
      if (!Array.isArray(this.cards)) return [];
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
    totalCardsInDeck() {
      return this.deck.reduce((total, deckItem) => total + deckItem.count, 0);
    },
  },
  mounted() {
    // Agrega automáticamente las cartas de deckProp al listado de seleccionadas
    if (Array.isArray(this.cards) && Array.isArray(this.deckProp.cards)) {
      this.deck = this.deckProp.cards.map(item => {
        if (item.card && typeof item.card === 'object') {
          return { card: this.cards.find(c => c.id === item.card.id) || item.card, count: item.count };
        }
        if (item.card_id) {
          return { card: this.cards.find(c => c.id === item.card_id), count: item.count };
        }
        return null;
      }).filter(item => item && item.card);
      this.deck_to_request = this.deck.map(item => ({ card: item.card.id, count: item.count }));
    } else {
      this.deck = [];
      this.deck_to_request = [];
    }
  },
  methods: {
    goToDeck() {
      this.$inertia.get(route('deck.list'));
    },
    addCardToDeck(card) {
      const existingCardIndex = this.deck.findIndex(deckItem => deckItem.card.id === card.id);

      if (existingCardIndex !== -1) {
        const currentCount = this.deck[existingCardIndex].count;
        if (currentCount < this.rarityLimits[card.rarity]) {
          this.deck[existingCardIndex].count++;
        } else {
          alert(`No puedes añadir más de ${this.rarityLimits[card.rarity]} cartas de rareza ${card.rarity}.`);
        }
      } else {
        this.deck.push({ card: card, count: 1 });
      }
      // Siempre actualiza deck_to_request
      this.deck_to_request = this.deck.map(item => ({ card: item.card.id, count: item.count }));
    },
    removeCardFromDeck(cardId) {
      const cardIndex = this.deck.findIndex(deckItem => deckItem.card.id === cardId);

      if (cardIndex !== -1) {
        if (this.deck[cardIndex].count > 1) {
          this.deck[cardIndex].count--;
        } else {
          this.deck.splice(cardIndex, 1);
        }
      }
      // Siempre actualiza deck_to_request
      this.deck_to_request = this.deck.map(item => ({ card: item.card.id, count: item.count }));
    },
    updateDeck() {
    //   if (this.totalCardsInDeck >= 30) {
        axios.put(route('deck.update', { deck: this.deckProp.id }), {
          name: this.deckProp.name,
          cards: this.deck_to_request,
        })
        .then(response => {
          alert('Mazo actualizado correctamente!');
        })
        .catch(error => {
          console.error('Error al actualizar el mazo:', error);
        });
    //   } else {
    //     alert('Hay que tener 30 cartas como mínimo');
    //   }
    },
  },
};
</script>
