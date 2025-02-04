<template>
    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-purple-950 to-black relative overflow-hidden">
      <!-- Background pattern -->
      <div class="absolute inset-0 opacity-10">
        <div v-for="i in 100" :key="i" 
             class="h-2 w-2 bg-white rounded-full absolute animate-pulse"
             :style="{
               left: `${Math.random() * 100}%`,
               top: `${Math.random() * 100}%`
             }">
        </div>
      </div>
  
      <!-- Main content -->
      <div class="relative z-10 flex flex-col items-center justify-center min-h-screen p-4 text-white">
        <!-- Open Profile Button -->
        <button @click="openModal" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200">
          Ver Perfil
        </button>
      </div>
  
      <!-- Modal -->
      <div v-if="show" class="fixed inset-0 bg-black/60 flex items-center justify-center z-50">
        <div class="bg-gray-800/90 backdrop-blur-lg rounded-lg w-full max-w-2xl h-[80vh] overflow-y-auto shadow-2xl p-6 space-y-6">
          <!-- Avatar and Name -->
          <div class="flex flex-col items-center gap-4">
            <div class="relative">
              <img :src="$page.props.auth.user.avatar" alt="User Avatar" class="w-32 h-32 object-cover rounded-full border-4 border-purple-500 shadow-lg" />
              <div class="absolute bottom-2 right-2">
                <button @click="changeAvatar" class="p-2 bg-gradient-to-r from-green-500 to-teal-500 hover:from-green-400 hover:to-teal-400 text-white rounded-full shadow-md transform hover:scale-105 transition-all duration-200">
                  📷
                </button>
              </div>
            </div>
            <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600">
              {{ $page.props.auth.user.name }}
            </h1>
            <p class="text-gray-400">UID: {{ $page.props.auth.user.id }}</p>
          </div>
  
          <!-- Experience Bar -->
          <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-400">Experiencia</label>
            <div class="w-full bg-gray-700/50 rounded-full h-4">
              <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full" :style="{ width: `${user.experience}%` }"></div>
            </div>
            <p class="text-xs text-gray-400">Nivel {{ $page.props.auth.user.level }} - {{ $page.props.auth.user.experience_points }}%</p>
          </div>
  
          <!-- Description -->
          <div>
            <label class="block text-sm font-medium text-gray-400">Descripción</label>
            <textarea v-model="user.description" rows="3" placeholder="Escribe algo sobre ti..."
                      class="w-full px-4 py-2 bg-gray-700/50 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500 resize-none"></textarea>
          </div>
  
          <!-- Frame Selection -->
          <div>
            <label class="block text-sm font-medium text-gray-400">Marco de Avatar</label>
            <div class="flex gap-4 mt-2">
              <button v-for="(frame, index) in frames" :key="index" @click="selectFrame(frame)"
                      :class="[
                        'w-16 h-16 rounded-full border-4',
                        selectedFrame === frame ? 'border-purple-500' : 'border-gray-700',
                        'hover:border-purple-400 transition-colors duration-200'
                      ]">
                <img :src="frame" alt="Frame" class="w-full h-full object-cover rounded-full" />
              </button>
            </div>
          </div>
  
          <!-- Action Buttons -->
          <div class="flex justify-between gap-4">
            <button @click="saveProfile" class="flex-1 px-6 py-3 bg-gradient-to-r from-green-500 to-teal-500 hover:from-green-400 hover:to-teal-400 text-white font-bold rounded-lg shadow-md transform hover:scale-105 transition-all duration-200">
              Guardar Cambios
            </button>
            <button @click="closeModal" class="flex-1 px-6 py-3 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-500 hover:to-rose-500 text-white font-bold rounded-lg shadow-md transform hover:scale-105 transition-all duration-200">
              Cerrar
            </button>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'UserProfileModal',
    props: {
      show: {
        type: Boolean,
        required: true
      }
    },
    data() {
      return {
        user: {
          avatar: '/img/avatar-default.png',
          name: 'StramersGamer',
          uid: '123456789',
          experience: 65,
          level: 5,
          description: 'Apasionado por los juegos de cartas y la estrategia.',
        },
        frames: [
          '/img/frame-1.png',
          '/img/frame-2.png',
          '/img/frame-3.png',
          '/img/frame-4.png',
        ],
        selectedFrame: null,
      };
    },
    methods: {
      closeModal() {
        this.$emit('close');
      },
      changeAvatar() {
        console.log('Funcionalidad para cambiar avatar');
        // Aquí puedes agregar la lógica para cambiar el avatar
      },
      selectFrame(frame) {
        this.selectedFrame = frame;
        console.log(`Marco seleccionado: ${frame}`);
        // Aquí puedes guardar el marco seleccionado
      },
      saveProfile() {
        console.log('Perfil guardado exitosamente');
        // Aquí puedes guardar los cambios en el perfil
      },
    },
  };
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
  
  /* Gradient animation for buttons */
  .bg-gradient-to-r {
    background-size: 200% auto;
    transition: background-position 0.5s ease;
  }
  .bg-gradient-to-r:hover {
    background-position: right center;
  }
  </style>