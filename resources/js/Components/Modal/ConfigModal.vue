<template>
  <div v-if="show" class="fixed inset-0 bg-black/20 flex items-center justify-center z-50">
    <div class="bg-gray-800/90 backdrop-blur-lg rounded-lg w-full max-w-4xl h-[80vh] overflow-y-auto shadow-2xl">
      <!-- Tabs -->
      <div class="flex border-b border-gray-700">
        <button v-for="(tab, index) in tabs" :key="index" @click="activeTab = tab"
                :class="[
                  'w-1/5 py-3 text-center text-lg font-medium cursor-pointer transition-colors duration-200',
                  activeTab === tab ? 'text-purple-400 border-b-2 border-purple-400' : 'text-gray-400 hover:text-gray-300'
                ]">
          {{ tab }}
        </button>
      </div>

      <!-- Content -->
      <div class="p-6 space-y-6">
        <!-- Game Tab -->
        <div v-if="activeTab === 'Game'" class="space-y-4">
          <h2 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600">
            Configuración del Juego
          </h2>
          <p class="text-gray-400">Ajusta las opciones generales del juego.</p>
          <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-400">Controles:</label>
            <!-- controles -->
          </div>
        </div>

        <!-- Video Tab -->
        <div v-if="activeTab === 'Video'" class="space-y-4">
          <h2 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600">
            Configuración de Video
          </h2>
          <p class="text-gray-400">Ajusta la calidad de video y otros parámetros visuales.</p>
          <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-400">Resolución</label>
            <select class="w-full px-4 py-2 bg-gray-700/50 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500">
              <option>1920x1080</option>
              <option>1280x720</option>
              <option>800x600</option>
            </select>
          </div>
        </div>

        <!-- Graphics Tab -->
        <div v-if="activeTab === 'Graphics'" class="space-y-4">
          <h2 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600">
            Configuración de Gráficos
          </h2>
          <p class="text-gray-400">Ajusta los gráficos para mejorar la experiencia visual.</p>
          <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-400">Calidad de Texturas</label>
            <select class="w-full px-4 py-2 bg-gray-700/50 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500">
              <option>Baja</option>
              <option>Media</option>
              <option>Alta</option>
            </select>
          </div>
        </div>

        <!-- Audio Tab -->
        <div v-if="activeTab === 'Audio'" class="space-y-4">
          <h2 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600">
            Configuración de Audio
          </h2>
          <p class="text-gray-400">Ajusta el volumen y otros parámetros de audio.</p>
          <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-400">Volumen General</label>
            <input type="range" min="0" max="100" class="w-full bg-gray-700/50 rounded-lg" />
          </div>
        </div>

        <!-- Account Tab -->
        <div v-if="activeTab === 'Cuenta'" class="space-y-4">
          <h2 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600">
            Configuración de Cuenta
          </h2>
          <div class="space-y-4">
            <!-- Name -->
            <div>
              <label class="block text-sm font-medium text-gray-400">Nombre</label>
              <input type="text" :placeholder="$page.props.auth.user.name" class="w-full px-4 py-2 bg-gray-700/50 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500" />
            </div>
            <!-- Email -->
            <div>
              <label class="block text-sm font-medium text-gray-400">Correo Electrónico</label>
              <input type="email" :placeholder="$page.props.auth.user.email" class="w-full px-4 py-2 bg-gray-700/50 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500" />
            </div>
            <!-- Password -->
            <div>
              <label class="block text-sm font-medium text-gray-400">Contraseña</label>
              <input type="password" placeholder="********" class="w-full px-4 py-2 bg-gray-700/50 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500" />
            </div>
            <!-- Two Factor Authentication -->
            <div>
              <label class="block text-sm font-medium text-gray-400">Autenticación de Dos Factores</label>
              <button class="w-full px-4 py-2 bg-gradient-to-r from-green-500 to-teal-500 hover:from-green-400 hover:to-teal-400 text-white font-bold rounded-lg shadow-md transform hover:scale-105 transition-all duration-200">
                Activar 2FA
              </button>
            </div>
            <!-- Browser Sessions -->
            <div>
              <label class="block text-sm font-medium text-gray-400">Sesiones del Navegador</label>
              <button class="w-full px-4 py-2 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-400 hover:to-orange-400 text-white font-bold rounded-lg shadow-md transform hover:scale-105 transition-all duration-200">
                Gestionar Sesiones
              </button>
            </div>
            <!-- Delete Account -->
            <div>
              <label class="block text-sm font-medium text-gray-400">Eliminar Cuenta</label>
              <button class="w-full px-4 py-2 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-500 hover:to-rose-500 text-white font-bold rounded-lg shadow-md transform hover:scale-105 transition-all duration-200">
                Eliminar Cuenta
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Close Button -->
      <div class="p-4 flex justify-end">
        <button @click="closeModal" class="px-6 py-2 bg-red-600 hover:bg-red-500 text-white font-bold rounded-lg shadow-md transform hover:scale-105 transition-all duration-200">
          Cerrar
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ConfigModal',
  props: {
    show: {
      type: Boolean,
      default: false
    }
  },
  emits: ['close'],
  data() {
    return {
      activeTab: 'Game',
      tabs: ['Game', 'Video', 'Graphics', 'Audio', 'Cuenta'],
    };
  },
  methods: {
    closeModal() {
      this.$emit('close');
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