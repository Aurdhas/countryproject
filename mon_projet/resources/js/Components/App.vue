<template>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <Header />

      <div v-if="isLoading" class="flex justify-center items-center py-12">
        <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500"></div>
      </div>

      <div v-else-if="error" class="text-center py-12 text-red-500">
        Error loading countries: {{ error }}
      </div>

      <div v-else>
        <div v-if="filteredCountries.length === 0" class="text-center py-12 text-gray-500">
          No countries found matching your criteria.
        </div>

        <div v-else class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
          <CountryCard
            v-for="country in filteredCountries"
            :key="country.alpha3Code"
            :country="country"
            class="transition-all duration-200 hover:shadow-lg"
          />
        </div>
      </div>
    </div>
  </template>

  <script setup>
  import { ref, computed, onMounted } from 'vue';
  import { useCountryStore } from '../stores/countryStore.js';
  import CountryCard from './CountryCard.vue';
  import Header from './Header.vue';

  const countryStore = useCountryStore();
  const isLoading = ref(false);
  const error = ref(null);

  const searchQuery = computed({
    get: () => countryStore.searchQuery,
    set: (value) => (countryStore.searchQuery = value),
  });

  const selectedRegion = computed({
    get: () => countryStore.selectedRegion,
    set: (value) => (countryStore.selectedRegion = value),
  });

  const uniqueRegions = computed(() => countryStore.uniqueRegions);
  const filteredCountries = computed(() => countryStore.filteredCountries);

  const handleSearch = () => {
    // Potentially add debounce here if needed
    countryStore.applyFilters();
  };

  const handleRegionChange = () => {
    countryStore.applyFilters();
  };

  onMounted(async () => {
    try {
      isLoading.value = true;
      await countryStore.fetchCountries();
    } catch (err) {
      error.value = err.message;
      console.error('Failed to load countries:', err);
    } finally {
      isLoading.value = false;
    }
  });
  </script>

  <style scoped>
  /* Custom transitions */
  .transition-all {
    transition-property: all;
  }
  </style>