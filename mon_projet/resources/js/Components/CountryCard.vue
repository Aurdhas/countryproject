<template>
    <Link
      :href="`/countries/${country.alpha3Code || country.id}`"
      class="block bg-white rounded-lg shadow-md overflow-hidden hover:scale-[1.02] transition-transform duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
      :aria-label="`View details about ${country.name}`"
    >
      <div class="relative pb-[60%]"> <!-- Ratio d'aspect 3:2 -->
        <img
          :src="country.flags?.svg || country.flag"
          :alt="`Flag of ${country.name}`"
          class="absolute w-full h-full object-cover"
          loading="lazy"
        />
      </div>
      <div class="p-4 text-left">
        <h3 class="font-bold text-lg mb-2 line-clamp-1">{{ country.name }}</h3>
        <ul class="space-y-1 text-sm">
          <li><strong class="font-semibold">Population:</strong> {{ (country.population || 0).toLocaleString() }}</li>
          <li><strong class="font-semibold">Region:</strong> {{ country.region || 'N/A' }}</li>
          <li><strong class="font-semibold">Capital:</strong> {{ country.capital || 'N/A' }}</li>
        </ul>
      </div>
    </Link>
  </template>

  <script setup>
  import { Link } from '@inertiajs/vue3';

  const props = defineProps({
    country: {
      type: Object,
      required: true,
      validator: (value) => {
        return value.name && (value.flag || value.flags?.svg)
      }
    },
  });
  </script>

  <style scoped>
  /* Transition plus douce */
  .transition-transform {
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  }
  </style>