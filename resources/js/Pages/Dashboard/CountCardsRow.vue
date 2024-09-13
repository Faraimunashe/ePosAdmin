<template>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <!-- Total Items Sold Card -->
      <div class="bg-white shadow-md rounded-lg p-6 flex items-center justify-between border-t-4 border-gray-500">
        <div>
          <h2 class="text-2xl font-semibold text-gray-900">USD Sales</h2>
          <p class="text-gray-600 mt-1 text-xl">${{ counts.usd.total }}</p>
        </div>
        <i class="fas fa-dollar-sign h-12 w-12 text-gray-500"></i>
      </div>

      <!-- Total Sales Card -->
      <div class="bg-white shadow-md rounded-lg p-6 flex items-center justify-between border-t-4 border-gray-500">
        <div>
          <h2 class="text-2xl font-semibold text-gray-900">USD Cash Sales</h2>
          <p class="text-gray-600 mt-1 text-xl">${{ counts.usd.cash }}</p>
        </div>
        <i class="fas fa-money-bill h-12 w-12 text-gray-500"></i>
      </div>

      <!-- Total Transactions Card -->
      <div class="bg-white shadow-md rounded-lg p-6 flex items-center justify-between border-t-4 border-gray-500">
        <div>
          <h2 class="text-2xl font-semibold text-gray-900">USD Card Sales</h2>
          <p class="text-gray-600 mt-1 text-xl">${{ counts.usd.card }}</p>
        </div>
        <i class="fas fa-credit-card h-12 w-12 text-gray-500"></i>
      </div>

      <!-- Total Revenue Card -->
      <div class="bg-white shadow-md rounded-lg p-6 flex items-center justify-between border-t-4 border-gray-500">
        <div>
          <h2 class="text-2xl font-semibold text-gray-900">ZWG Sales</h2>
          <p class="text-gray-600 mt-1 text-xl">${{ counts.zwg.total }}</p>
        </div>
        <i class="fas fa-dollar-sign h-12 w-12 text-gray-500"></i>
      </div>

      <!-- Total Sales Card -->
      <div class="bg-white shadow-md rounded-lg p-6 flex items-center justify-between border-t-4 border-gray-500">
        <div>
          <h2 class="text-2xl font-semibold text-gray-900">ZWG Cash Sales</h2>
          <p class="text-gray-600 mt-1 text-xl">${{ counts.zwg.cash }}</p>
        </div>
        <i class="fas fa-money-bill h-12 w-12 text-gray-500"></i>
      </div>

      <!-- Total Transactions Card -->
      <div class="bg-white shadow-md rounded-lg p-6 flex items-center justify-between border-t-4 border-gray-500">
        <div>
          <h2 class="text-2xl font-semibold text-gray-900">ZWG Card Sales</h2>
          <p class="text-gray-600 mt-1 text-xl">${{ counts.zwg.card }}</p>
        </div>
        <i class="fas fa-credit-card h-12 w-12 text-gray-500"></i>
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
