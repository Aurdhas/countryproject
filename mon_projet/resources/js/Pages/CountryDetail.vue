<template>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Bouton Retour -->
      <button 
        @click="$inertia.visit('/')"
        class="flex items-center gap-2 mb-12 px-6 py-2 bg-white dark:bg-gray-800 shadow rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Back
      </button>
  
      <!-- Détails du pays -->
      <div v-if="country" class="flex flex-col lg:flex-row gap-16 items-center">
        <!-- Drapeau -->
        <div class="w-full lg:w-1/2">
          <img 
            :src="country.flag" 
            :alt="'Flag of ' + country.name"
            class="w-full max-w-lg h-auto object-cover shadow-lg rounded-lg"
          />
        </div>
  
        <!-- Informations -->
        <div class="w-full lg:w-1/2 text-left">
          <h2 class="text-3xl font-bold mb-6">{{ country.name }}</h2>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <div class="space-y-2">
              <p><strong>Native Name:</strong> {{ country.nativeName ?? 'N/A' }}</p>
              <p><strong>Population:</strong> {{ country.population?.toLocaleString() ?? 'N/A' }}</p>
              <p><strong>Region:</strong> {{ country.region ?? 'N/A' }}</p>
              <p><strong>Sub Region:</strong> {{ country.subregion ?? 'N/A' }}</p>
              <p><strong>Capital:</strong> {{ country.capital ?? 'N/A' }}</p>
            </div>
            
            <div class="space-y-2">
              <p><strong>Top Level Domain:</strong> {{ country.topLevelDomain?.join(', ') ?? 'N/A' }}</p>
              <p><strong>Currencies:</strong> {{ formatCurrencies(country.currencies) }}</p>
              <p><strong>Languages:</strong> {{ formatLanguages(country.languages) }}</p>
            </div>
          </div>
  
          <!-- Pays frontaliers -->
          <div v-if="country.borders?.length" class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <strong class="whitespace-nowrap">Border Countries:</strong>
            <div class="flex flex-wrap gap-2">
              <a
                v-for="border in country.borders"
                :key="border"
                :href="`/countries/${border}`"
                class="px-4 py-1 bg-white dark:bg-gray-800 shadow rounded hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
              >
                {{ getCountryName(border) }}
              </a>
            </div>
          </div>
        </div>
      </div>
  
      <div v-else class="text-center py-8 text-gray-500">
        <span v-if="isLoading">Loading country details...</span>
        <span v-else>Country not found</span>
      </div>
    </div>
  </template>
  
  <script setup>
  import { onMounted, computed, ref } from 'vue';
  import { usePage } from '@inertiajs/vue3';
  import { useCountryStore } from '../stores/countryStore.js';
  
  const { props } = usePage();
  const id = props.id;
  const countryStore = useCountryStore();
  const isLoading = ref(false);
  
  // Formatage des devises
  const formatCurrencies = (currencies) => {
    if (!currencies) return 'N/A';
    return Object.values(currencies).map(c => c.name).join(', ');
  };
  
  // Formatage des langues
  const formatLanguages = (languages) => {
    if (!languages) return 'N/A';
    return Object.values(languages).join(', ');
  };
  
  // Récupération du nom du pays frontalier
  const getCountryName = (code) => {
    return countryStore.countries.find(c => c.alpha3Code === code)?.name || code;
  };
  
  // Récupérer le pays à partir du store
  const country = computed(() => {
    return countryStore.countries.find((country) => country.alpha3Code === id);
  });
  
  onMounted(async () => {
    // Si le pays n'est pas encore dans le store, le charger
    if (!country.value) {
      isLoading.value = true;
      try {
        await countryStore.fetchCountries();
      } finally {
        isLoading.value = false;
      }
    }
  });
  </script>
  
  <style scoped>
  .container {
    max-width: 1280px;
  }
  </style>