<template>
    <Head title="Items"/>
    <div class="max-w-7xl mx-auto px-4 py-6">
      <!-- Title and Create Item Button -->
      <div class="flex justify-between items-center mb-6">
        <!-- Title -->
        <h1 class="text-3xl font-bold text-gray-900">Available Items</h1>

        <!-- Search Input -->
        <div class="flex items-center space-x-3">
        <input
            v-model="search"
            type="search"
            placeholder="Search items..."
            class="w-64 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
        />

        <!-- Create Item Button -->
        <a
            href="/items/create"
            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
        >
            <svg
            class="w-5 h-5 mr-2"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 4v16m8-8H4"
            />
            </svg>
            Create Item
        </a>
        </div>
    </div>


      <!-- Items Table Card -->
      <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item Name</th>
              <th scope="col" class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
              <th scope="col" class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <!-- Example Item Row -->
            <tr v-for="item in items.data" :key="item.id">
              <td class="py-4 px-6 text-sm font-medium text-gray-900">{{ item.name }}</td>
              <td class="py-4 px-6 text-sm text-gray-500">${{ item.price }}</td>
              <td class="py-4 px-6 text-sm font-medium">
                <Link :href="'/items/' + item.id" class="text-blue-600 hover:text-blue-900">
                    <i class="fas fa-eye"></i>
                </Link>
                <a href="/items/1/delete" class="text-red-600 hover:text-red-900 ml-4">
                    <i class="fas fa-trash-alt"></i>
                </a>
              </td>
            </tr>
            <!-- Add more item rows here -->
          </tbody>
        </table>
      </div>
      <Pagination :links="items.links"/>
    </div>
  </template>

<script>
import Layout from "../Shared/Layout.vue";
import Pagination from "../Shared/Components/Pagination.vue"
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3'

export default {
    layout: Layout,
    props: {
        items: Array
    },
    components: {
        Pagination
    },
    setup() {
        const search = ref('');

        watch(search, (value) => {
            router.get(
                '/items',
                {search: value},
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true
                }
            )

        });

        return {
            search,
        };
    },
}
</script>


<style scoped>
table {
  width: 100%;
  border-collapse: collapse;
}

th, td {
  padding: 0.75rem;
}

thead {
  background-color: #f3f4f6;
}

tbody tr:nth-child(even) {
  background-color: #f9fafb;
}

tbody tr:hover {
  background-color: #f1f5f9;
}
</style>
