<template>
    <Head title="Login" />
    <div class="bg-gray-100 flex items-center justify-center min-h-screen">
      <!-- Container -->
      <div class="container mx-auto py-5">
        <div class="flex justify-center items-center min-h-screen">
          <form @submit.prevent="submit" class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full">
            <!-- Logo -->
            <div class="flex justify-center mb-4">
              <a href="/" class="flex items-center space-x-2">
                <img src="../../../assets/images/msu.png" alt="Company Logo" width="58" class="w-14 h-auto">
                <span class="text-2xl font-bold">ePOS Admin</span>
              </a>
            </div>

            <!-- Header -->
            <div class="text-center mb-7">
              <p class="text-gray-600">Get access to your account</p>
            </div>

            <!-- Email Input -->
            <div class="mb-4">
              <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Email address</label>
              <div class="form-icon-container">
                <input v-model="form.email" type="email" id="email" placeholder="name@example.com"
                  :class="{'border-red-500': form.errors.email}" class="form-icon-input w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                <div v-if="form.errors.email" class="invalid-feedback text-red-500">{{ form.errors.email }}</div>
              </div>
            </div>

            <!-- Password Input -->
            <div class="mb-6">
              <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Password</label>
              <div class="form-icon-container">
                <input v-model="form.password" type="password" id="password" placeholder="Password"
                  :class="{'border-red-500': form.errors.password}" class="form-icon-input w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                <div v-if="form.errors.password" class="invalid-feedback text-red-500">{{ form.errors.password }}</div>
              </div>
            </div>

            <!-- Remember Me and Forgot Password -->
            <div class="flex items-center justify-between mb-6">
              <div class="flex items-center">
                <input v-model="form.remember" type="checkbox" id="remember" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="remember" class="ml-2 text-sm text-gray-700">Remember me</label>
              </div>
              <a href="#" class="text-sm text-blue-600 hover:text-blue-700">Forgot Password?</a>
            </div>

            <!-- Submit Button -->
            <button :disabled="loading" type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
              <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
              <span v-if="!loading">Sign In</span>
              <span v-if="loading"> Signing In...</span>
            </button>
          </form>
        </div>
      </div>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue';
  import { useForm } from '@inertiajs/vue3';

  const form = useForm({
    email: '',
    password: '',
    remember: false,
  });

  const loading = ref(false);

  const submit = () => {
    loading.value = true;
    form.post('/login', {
      onFinish: () => loading.value = false,
    });
  };
  </script>

  <style scoped>
    .form-icon-container {
        position: relative;
    }
    .form-icon {
        position: absolute;
        top: 50%;
        right: 0.75rem;
        transform: translateY(-50%);
    }
    .form-icon-input {
        padding-right: 2.5rem;
    }
    .invalid-feedback {
    display: block;
  }
  </style>
