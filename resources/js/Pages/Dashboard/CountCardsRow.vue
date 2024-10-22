<template>
    <div class="container mx-auto mb-4">
      <div v-for="(currencyData, currency) in counts" :key="currency" class="flex flex-wrap mb-2">
        <div class="w-full md:w-1/3 p-2">
          <div class="bg-white shadow-lg rounded-lg p-4 text-center transition-transform transform hover:scale-105 hover:shadow-xl">
            <h2 class="text-lg font-semibold text-gray-800">{{ currency }} Sales</h2>
            <p class="text-2xl font-bold text-blue-600">${{ currencyData.total }}</p>
          </div>
        </div>

        <div class="w-full md:w-1/3 p-2">
          <div class="bg-white shadow-lg rounded-lg p-4 text-center transition-transform transform hover:scale-105 hover:shadow-xl">
            <h2 class="text-lg font-semibold text-gray-800">{{ currency }} Cash Sales</h2>
            <p class="text-2xl font-bold text-blue-600">${{ currencyData.CASH }}</p>
          </div>
        </div>

        <div class="w-full md:w-1/3 p-2">
          <div class="bg-white shadow-lg rounded-lg p-4 text-center transition-transform transform hover:scale-105 hover:shadow-xl">
            <h2 class="text-lg font-semibold text-gray-800">{{ currency }} Card Sales</h2>
            <p class="text-2xl font-bold text-blue-600">${{ currencyData.EFT }}</p>
          </div>
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
