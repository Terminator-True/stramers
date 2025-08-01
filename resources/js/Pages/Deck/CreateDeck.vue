<template>
  <div class="min-h-screen p-4 pt-20 text-white bg-gray-900">
    <button @click="$inertia.visit(route('dashboard'))" class="absolute flex items-center gap-2 px-6 py-3 font-bold text-white transition-all duration-200 transform rounded-lg shadow-lg top-6 left-6 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 hover:scale-105">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
      </svg>
    </button>
    <!-- Encabezado -->
    <h1 class="mb-6 text-3xl font-bold">Creador de Mazos</h1>

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
            v-for="cardItem in deck"
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
        <!-- Botón Crear Mazo -->
        <button
          @click="createDeck"
          class="w-full px-6 py-3 mt-6 font-bold text-white bg-blue-600 rounded-lg hover:bg-blue-500"
        >
          Crear Mazo
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
      const existingCardIndex = this.deck.findIndex(deckItem => deckItem.card.id === card.id);

      if (existingCardIndex !== -1) {
        const currentCount = this.deck[existingCardIndex].count;
        if (currentCount < this.rarityLimits[card.rarity]) {
          this.deck[existingCardIndex].count++;
        } else {
          alert(`No puedes añadir más de ${this.rarityLimits[card.rarity]} cartas de rareza ${card.rarity}.`);
        }
      } else {
        // Si no está en el mazo, la agregamos con cantidad inicial de 1
        this.deck.push({ card: card, count: 1 });
        this.deck_to_request.push({ card: card.id, count: 1 });
      }
    },
    removeCardFromDeck(cardId) {
      const cardIndex = this.deck.findIndex(deckItem => deckItem.card.id === cardId);

      if (cardIndex !== -1) {
        if (this.deck[cardIndex].count > 1) {
          // Si la cantidad es mayor a 1, decrementamos
          this.deck[cardIndex].count--;
        } else {
          // Si la cantidad es 1, eliminamos la carta del mazo
          this.deck.splice(cardIndex, 1);
        }
      }
    },
    getCardById(id) {
      console.log(typeof(id));
      const card = this.cards.find((card) => card.id === Number(id));
      console.log(card);
      return card;
    },
    createDeck() {

    let config = {
      method: 'post',
      url: route('deck.store'),
      data: {
        name: "mazo",
        cards: this.deck_to_request,
      },
    }
      if (this.deck.reduce((total, deckItem) => total + deckItem.count, 0) >= 30){
        axios.request(config)
        .then(response => {
          alert("Mazo creado!");
          console.log("Mazo:", this.deck);
        })
        .catch(error => {
          console.error('Error createDeck:', error);
        });
      } else{
        alert('hay que tener 30 cartas como minimo')
      }
    },
  },
};
</script>
