<template>
    <Head title="Item Details" />
    <div class="max-w-7xl mx-auto p-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Item Details</h1>
      <!-- Item Details Card -->
      <div class="bg-white shadow-sm rounded-lg p-6 mb-6">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Item Information -->
          <div>
            <h2 class="text-xl font-semibold text-gray-800">Item Information</h2>
            <table class="min-w-full divide-y divide-gray-200 mt-4">
              <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                  <th class="px-6 py-3 text-left text-gray-500">Item Name</th>
                  <td class="px-6 py-4 text-gray-900">{{ item.name }}</td>
                </tr>
                <tr>
                  <th class="px-6 py-3 text-left text-gray-500">Price</th>
                  <td class="px-6 py-4 text-gray-900">{{ item.price }}</td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Actions Card -->
          <div class="flex items-center justify-end space-x-4">
            <InertiaLink
              href="{{ route('items.edit', item.id) }}"
              class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              <i class="fas fa-pencil-alt"></i> Edit
            </InertiaLink>
            <button
              @click="deleteItem"
              class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500"
            >
              <i class="fas fa-trash"></i> Delete
            </button>
          </div>
        </div>
      </div>

      <!-- Sales Data Card -->
      <div class="bg-white shadow-sm rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Sales Data</h2>
        <div class="flex flex-col space-y-4">
          <div class="bg-gray-100 p-4 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-700">Total Sales</h3>
            <p class="text-gray-900 mt-2">{{ salesData.totalSales }} units</p>
          </div>
          <div class="bg-gray-100 p-4 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-700">Total Revenue</h3>
            <p class="text-gray-900 mt-2">${{ salesData.totalRevenue }}</p>
          </div>
          <div class="bg-gray-100 p-4 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-700">Sales History</h3>
            <table class="min-w-full divide-y divide-gray-200 mt-4">
              <thead>
                <tr>
                  <th class="px-6 py-3 text-left text-gray-500">Date</th>
                  <th class="px-6 py-3 text-left text-gray-500">Quantity Sold</th>
                  <th class="px-6 py-3 text-left text-gray-500">Revenue</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="sale in salesData.history.data" :key="sale.id">
                  <td class="px-6 py-4 text-gray-900">{{ sale.date }}</td>
                  <td class="px-6 py-4 text-gray-900">{{ sale.quantity }}</td>
                  <td class="px-6 py-4 text-gray-900">${{ sale.revenue }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <Pagination :links="salesData.history.links"/>
        </div>
      </div>
    </div>
  </template>

<script>
import Pagination from "../../Shared/Components/Pagination.vue";
import Layout from "../../Shared/Layout.vue";

export default {
    layout: Layout,
    props: {
        item: Object,
        salesData: Object
    },
    components: {
        Pagination
    }
}
</script>
