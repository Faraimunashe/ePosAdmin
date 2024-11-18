<template>
    <div v-if="isOpen" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl p-6 max-w-lg w-full">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Delete Admin User</h2>
            <p class="text-gray-600 mb-6">Are you sure you want to delete this admin user? This action cannot be undone.</p>

            <div class="flex justify-end space-x-4">
                <button @click="closeModal" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">Cancel</button>
                <button @click="deleteUser" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">Delete</button>
            </div>
      </div>
    </div>
</template>

<script>
  export default {
    props: {
      isOpen: Boolean,
      userId: Number,
    },
    methods: {
      closeModal() {
        this.$emit('close');
      },
      deleteUser() {
        this.$emit('confirm-delete', this.userId);
      }
    }
  }
  </script>

  <style scoped>
  /* Modal animations, etc. */
  </style>
