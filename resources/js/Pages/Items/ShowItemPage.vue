<template>
    <Head title="Item Details"/>
    <div class="max-w-7xl mx-auto p-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Item Details</h1>

        <SuccessAlert v-if="$page.props.errors.success" :message="$page.props.errors.success" />
        <ErrorAlert v-if="$page.props.errors.error" :message="$page.props.errors.error" />
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
                                <td class="px-6 py-4 text-gray-900">
                                    <span v-if="!isEditing">{{ item.name }}</span>
                                    <input v-else v-model="editedItem.name" type="text" :class="{'border-red-500': $page.props.errors.name}" class="border rounded-md px-4 py-2 w-full">
                                    <div v-if="$page.props.errors.name" class="invalid-feedback text-red-500">{{ $page.props.errors.name }}</div>
                                </td>
                            </tr>
                            <tr>
                                <th class="px-6 py-3 text-left text-gray-500">Price</th>
                                <td class="px-6 py-4 text-gray-900">
                                    <span v-if="!isEditing">${{ item.price }}</span>
                                    <input v-else v-model="editedItem.price" type="number" :class="{'border-red-500': $page.props.errors.price}" class="border rounded-md px-4 py-2 w-full">
                                    <div v-if="$page.props.errors.price" class="invalid-feedback text-red-500">{{ $page.props.errors.price }}</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-4">
                    <button v-if="!isEditing" @click="startEditing" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        <i class="fas fa-pencil-alt"></i> Edit
                    </button>

                    <button v-if="isEditing" @click="saveChanges" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        <i class="fas fa-save"></i> Save
                    </button>
                    <button v-if="isEditing" @click="cancelEditing" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Cancel
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
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import Pagination from "../../Shared/Components/Pagination.vue";
import Layout from '../../Shared/Layout.vue';
import SuccessAlert from '../../Shared/Components/SuccessAlert.vue';
import ErrorAlert from '../../Shared/Components/ErrorAlert.vue';

export default {
    layout: Layout,
    props: {
        item: Object,
        salesData: Object
    },
    components: {
        Pagination, SuccessAlert, ErrorAlert
    },
    setup(props) {
        const isEditing = ref(false);
        const editedItem = ref({ ...props.item });

        const startEditing = () => {
            isEditing.value = true;
        };

        const saveChanges = () => {
            router.put(`/items/${props.item.id}`, editedItem.value, {
                onSuccess: () => {
                    isEditing.value = false;
                    console.log('Item updated successfully');
                },
                onError: (errors) => {
                    console.error('Failed to update item:', errors);
                },
            });
        };

        const cancelEditing = () => {
            isEditing.value = false;
            editedItem.value = { ...props.item }; // Reset values
        };

        return {
            isEditing,
            editedItem,
            startEditing,
            saveChanges,
            cancelEditing,
        };
    }
}
</script>
