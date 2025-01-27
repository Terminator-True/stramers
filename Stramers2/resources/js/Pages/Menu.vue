<template>
    <div class="flex flex-col justify-end min-h-screen pb-8 bg-gray-100 ">
        <video class="video-background" autoplay loop muted>
            <source src="" type="video/mp4">
        </video>
        <div class="flex flex-row justify-center items-center">
            <!-- Botones perfil -->
            <div class="flex flex-col mt-4 bg-gray-400 p-2 rounded-md ">
                <p
                class="px-6 py-2 font-bold text-white rounded-xl mb-2"
                >
                Profile
                </p>
                <a :href="route('profile.show')" 
                class="px-6 py-2 text-sm font-bold text-white bg-gray-300 shadow-md rounded-xl hover:bg-gray-500"
                >
                Jorextor
                </a>
            </div>

            <!-- Botones principales -->
            <div class="flex mt-4 bg-gray-400 p-3 mx-2 rounded-md ">
                <a :href="route('play')" 
                class="px-10 py-6 text-xl font-bold text-white bg-blue-500 rounded-md hover:bg-blue-700 mr-2"
                >
                PLAY
                </a>
                <a :href="route('deck')"
                class="px-10 py-6 text-xl font-bold text-white bg-green-500 rounded-md hover:bg-green-700 mr-2"
                >
                Mazos
                </a>
                <a :href="route('shop')"
                class="px-10 py-6 text-xl font-bold text-white bg-purple-500 rounded-md hover:bg-purple-700"
                >
                Tienda
                </a>
            </div>
        
            <!-- Botones secundarios -->
            <div class="flex flex-col mt-4 bg-gray-400 p-2 rounded-md ">
                <button
                class="px-6 py-2 text-sm font-bold text-white bg-orange-500 rounded-xl hover:bg-orange-700 mb-2"
                >
                OPTIONS
                </button>

                <form method="POST" @submit.prevent="logout">
                    <ResponsiveNavLink as="button" class="px-6 py-2 text-sm font-bold text-white bg-red-500 rounded-xl text-center hover:bg-red-700">
                        QUIT
                    </ResponsiveNavLink>
                </form>

            </div>
        
        </div>
        <!-- Controles inferiores -->
        <div class="flex items-center space-x-6 justify-center mt-10">
            <button
                class="text-sm font-semibold text-white bg-gray-300 p-1 rounded-xl hover:text-gray-200"
            >
                <i class="fas fa-globe"></i> English
            </button>
            <button
                class="text-sm font-semibold text-white bg-blue-300 p-1 rounded-xl hover:text-gray-200"
            >
                <i class="fab fa-discord"></i> Discord
            </button>
            <button
                class="text-sm font-semibold text-white bg-gray-800 p-1 rounded-xl hover:text-gray-200"
            >
                <i class="fab fa-twitter"></i> Twitter
            </button>
        </div>
    </div>
  </template>
  
  <script>
  export default {
    name: "App",
  };
  </script>
  
  <style>

  </style>
  