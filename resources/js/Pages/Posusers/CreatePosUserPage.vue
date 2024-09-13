<template>
    <Head title="Create Pos User" />
    <div class="max-w-7xl mx-auto p-6">
      <!-- Page Title -->
      <h1 class="text-4xl font-bold text-gray-900 mb-8">Create New POS User</h1>

      <!-- Form Card -->
      <div class="bg-white shadow-md rounded-lg p-8">
        <SuccessAlert v-if="form.errors.success" :message="form.errors.success" />
        <ErrorAlert v-if="form.errors.error" :message="form.errors.error" />
        <form @submit.prevent="submit" class="space-y-6">
          <div>
            <label for="name" class="block text-gray-700 font-medium">Username <code class="text-red-500">*</code></label>
            <input
              v-model="form.name"
              id="name"
              type="text"
              placeholder="Enter username"
              required
              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-2 px-4 text-gray-900"
            />
            <span v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</span>
          </div>

          <div>
            <label for="price" class="block text-gray-700 font-medium">Email Address <code class="text-red-500">*</code></label>
            <input
              v-model="form.email"
              id="email"
              type="email"
              required
              placeholder="Enter email address"
              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-2 px-4 text-gray-900"
            />
            <span v-if="form.errors.email" class="text-red-500 text-sm">{{ form.errors.email }}</span>
          </div>

          <div>
            <label for="password" class="block text-gray-700 font-medium">Password <code class="text-red-500">*</code></label>
            <input
              v-model="form.password"
              id="password"
              type="password"
              placeholder="Enter password"
              required
              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-2 px-4 text-gray-900"
            />
            <span v-if="form.errors.password" class="text-red-500 text-sm">{{ form.errors.password }}</span>
          </div>

          <div>
            <label for="password" class="block text-gray-700 font-medium">Confirm Password <code class="text-red-500">*</code></label>
            <input
              v-model="form.password_confirmation"
              id="password"
              type="password"
              placeholder="Enter password confirmation"
              required
              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-2 px-4 text-gray-900"
            />
            <span v-if="form.errors.password_confirmation" class="text-red-500 text-sm">{{ form.errors.password_confirmation }}</span>
          </div>

          <!-- Submit Button -->
          <div class="flex justify-end">
            <button
              type="submit"
              :disabled="form.processing"
              class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 flex items-center justify-center"
            >
              <span v-if="form.processing" class="mr-2">Submitting...</span>
              <span v-if="!form.processing">Create Pos User</span>
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
    email: '',
    password: '',
    password_confirmation: ''
  });

  const errors = ref({});

  const submit = () => {
    form.post('/pos-users', {
      onError: (errors) => {
        errors.value = errors;
      },
      onSuccess: () => {
        form.reset();
      }
    });
  };
  </script>
