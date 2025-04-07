<template>
    <header class="bg-white shadow-sm py-6 px-4 sm:px-6 lg:px-8">
      <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
          <!-- Titre -->
          <h1 class="text-xl font-bold text-gray-900">Where in the world?</h1>

          <!-- Conteneur des filtres -->
          <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
            <!-- Barre de recherche -->
            <div class="relative flex-grow sm:flex-grow-0 sm:w-64">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
              <input
                type="text"
                v-model="searchQuery"
                placeholder="Search for a country..."
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              />
            </div>

            <!-- Filtre par région -->
            <select
              v-model="selectedRegion"
              class="block w-full sm:w-48 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            >
              <option value="">Filter by Region</option>
              <option v-for="region in regions" :key="region" :value="region">
                {{ region }}
              </option>
            </select>
          </div>
        </div>
      </div>
    </header>
  </template>

  <script setup>
  import { ref } from 'vue';

  const searchQuery = ref('');
  const selectedRegion = ref('');
  const regions = ['Africa', 'Americas', 'Asia', 'Europe', 'Oceania']; // Exemple de régions
  </script>

  <style scoped>
  /* Animation douce pour les interactions */
  input, select {
    transition: all 0.2s ease-in-out;
  }
  </style>