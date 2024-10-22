<template>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
      <div v-for="(currencyData, currency) in counts" :key="currency">
        <!-- Total Items Sold Card -->
        <div class="bg-white shadow-md rounded-lg p-6 flex items-center justify-between border-t-4 border-gray-500">
          <div>
            <h2 class="text-2xl font-semibold text-gray-900">{{ currency }} Sales</h2>
            <p class="text-gray-600 mt-1 text-xl">${{ currencyData.total }}</p>
          </div>
          <i class="fas fa-dollar-sign h-12 w-12 text-gray-500"></i>
        </div>

        <!-- Total Cash Sales Card -->
        <div class="bg-white shadow-md rounded-lg p-6 flex items-center justify-between border-t-4 border-gray-500">
          <div>
            <h2 class="text-2xl font-semibold text-gray-900">{{ currency }} Cash Sales</h2>
            <p class="text-gray-600 mt-1 text-xl">${{ currencyData.CASH }}</p>
          </div>
          <i class="fas fa-money-bill h-12 w-12 text-gray-500"></i>
        </div>

        <!-- Total Card Sales Card -->
        <div class="bg-white shadow-md rounded-lg p-6 flex items-center justify-between border-t-4 border-gray-500">
          <div>
            <h2 class="text-2xl font-semibold text-gray-900">{{ currency }} Card Sales</h2>
            <p class="text-gray-600 mt-1 text-xl">${{ currencyData.EFT }}</p>
          </div>
          <i class="fas fa-credit-card h-12 w-12 text-gray-500"></i>
        </div>
      </div>
    </div>
  </template>

  <script>
  export default {
    props: {
      counts: Object
    }
  }
  </script>

  <style scoped>
  /* Ensure FontAwesome icons are properly sized */
  i {
    font-size: 3rem;
  }
  </style>
