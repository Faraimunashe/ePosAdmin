<template>
    <Head title="Create Item" />
    <div class="max-w-7xl mx-auto p-6">
      <!-- Page Title -->
      <h1 class="text-4xl font-bold text-gray-900 mb-8">Create New Item</h1>

      <!-- Form Card -->
      <div class="bg-white shadow-md rounded-lg p-8">
        <SuccessAlert v-if="form.errors.success" :message="form.errors.success" />
        <ErrorAlert v-if="form.errors.error" :message="form.errors.error" />
        <form @submit.prevent="submit" class="space-y-6">
          <!-- Item Name -->
          <div>
            <label for="name" class="block text-gray-700 font-medium">Item Name <code class="text-red-500">*</code></label>
            <input
              v-model="form.name"
              id="name"
              type="text"
              placeholder="Enter item name"
              required
              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-2 px-4 text-gray-900"
            />
            <span v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</span>
          </div>

          <!-- Item Price -->
          <div>
            <label for="price" class="block text-gray-700 font-medium">Item Price <code class="text-red-500">*</code></label>
            <input
              v-model="form.price"
              id="price"
              type="number"
              step="0.01"
              required
              placeholder="Enter item price"
              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-2 px-4 text-gray-900"
            />
            <span v-if="form.errors.price" class="text-red-500 text-sm">{{ form.errors.price }}</span>
          </div>

          <!-- Submit Button -->
          <div class="flex justify-end">
            <button
              type="submit"
              :disabled="form.processing"
              class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 flex items-center justify-center"
            >
              <span v-if="form.processing" class="mr-2">Submitting...</span>
              <span v-if="!form.processing">Create Item</span>
              <svg
                v-if="form.processing"
                class="w-5 h-5 animate-spin text-white"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4 12a8 8 0 1116 0 8 8 0 01-16 0z"
                />
              </svg>
            </button>
          </div>
        </form>
      </div>
    </div>
  </template>

<script>
import Layout from "../../Shared/Layout.vue";
import SuccessAlert from '../../Shared/Components/SuccessAlert.vue';
import ErrorAlert from '../../Shared/Components/ErrorAlert.vue';

export default {
    layout: Layout,
    components: {
        SuccessAlert, ErrorAlert
    }
}
</script>

  <script setup>
  import { ref } from 'vue';
  import { useForm } from '@inertiajs/vue3';

  const form = useForm({
    name: '',
    price: ''
  });

  const errors = ref({});

  const submit = () => {
    form.post('/items', {
      onError: (errors) => {
        errors.value = errors;
      },
      onSuccess: () => {
        form.reset();
      }
    });
  };
  </script>
