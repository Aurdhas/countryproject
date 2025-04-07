import { defineStore } from 'pinia';
import axios from 'axios';

export const useCountryStore = defineStore('country', {
  state: () => ({
    countries: [],
    countryDetails: null,
    searchQuery: '',
    selectedRegion: '',
    loading: false,
    error: null,
    lastFetch: null, // Pour le cache local
  }),

  getters: {
    uniqueRegions: (state) => {
      if (!state.countries.length) return [];
      return [...new Set(state.countries.map((c) => c.region))].sort();
    },

    filteredCountries: (state) => {
      const query = state.searchQuery.toLowerCase();
      const region = state.selectedRegion;

      return state.countries.filter((country) => {
        const matchesSearch = !query ||
          country.name.toLowerCase().includes(query) ||
          (country.capital && country.capital.toLowerCase().includes(query));

        const matchesRegion = !region || country.region === region;

        return matchesSearch && matchesRegion;
      });
    },

    shouldFetchCountries: (state) => {
      // Seulement rafraîchir si les données ont plus de 5 minutes
      return !state.lastFetch || (Date.now() - state.lastFetch) > 300000;
    },
  },

  actions: {
    async fetchCountries(force = false) {
      if (!force && !this.shouldFetchCountries) return;

      this.loading = true;
      this.error = null;

      try {
        const response = await axios.get('/api/countries');
        this.countries = this.transformCountries(response.data);
        this.lastFetch = Date.now();
      } catch (error) {
        this.error = this.handleApiError(error);
        console.error('Erreur lors de la récupération des pays:', error);
      } finally {
        this.loading = false;
      }
    },

    async fetchCountryDetails(id) {
      if (this.countryDetails?.alpha3Code === id) return;

      this.loading = true;
      this.error = null;

      try {
        const response = await axios.get(`/api/countries/${id}`);
        this.countryDetails = this.transformCountryDetails(response.data);
      } catch (error) {
        this.error = this.handleApiError(error);
        console.error('Erreur lors de la récupération des détails:', error);
      } finally {
        this.loading = false;
      }
    },

    clearCountryDetails() {
      this.countryDetails = null;
    },

    setSearchQuery(query) {
      this.searchQuery = query.trim();
    },

    setRegion(region) {
      this.selectedRegion = region;
    },

    // Helpers
    transformCountries(countries) {
      return countries.map(country => ({
        alpha3Code: country.alpha3Code,
        name: country.name,
        flag: country.flag,
        population: country.population,
        region: country.region,
        capital: country.capital,
        subregion: country.subregion,
      }));
    },

    transformCountryDetails(country) {
      return {
        ...country,
        languages: country.languages ? Object.values(country.languages) : [],
        currencies: country.currencies ? Object.values(country.currencies).map(c => c.name) : [],
      };
    },

    handleApiError(error) {
      if (error.response) {
        switch (error.response.status) {
          case 404: return 'Pays non trouvé';
          case 500: return 'Erreur serveur';
          default: return 'Erreur inattendue';
        }
      }
      return 'Problème de connexion';
    }
  },
});