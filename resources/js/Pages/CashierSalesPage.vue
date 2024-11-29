<template>
    <Head title="Sales" />
    <div class="max-w-7xl mx-auto px-4 py-6">
        <h1 class="text-4xl font-semibold text-gray-900 mb-4 lg:mb-0">Sales Records</h1>
        <div class="flex flex-col lg:flex-row justify-between items-center mb-8 p-6 bg-white rounded-lg shadow-md">
            <div class="flex flex-col lg:flex-row lg:space-x-4 space-y-4 lg:space-y-0 items-center w-full">

                <div class="flex flex-col w-full md:w-auto">
                    <label for="cashier" class="mb-1 text-gray-700 font-medium">Cashier</label>
                    <select v-model="cashier" id="cashier" class="px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out">
                        <option value="">Select Cashier</option>
                        <option v-for="cas in cashiers" :key="cas.id" :value="cas.id">{{ cas.name }}</option>
                    </select>
                </div>

                <div class="flex flex-col w-full md:w-auto">
                    <label for="startDate" class="mb-1 text-gray-700 font-medium">Start Date</label>
                    <input
                        v-model="startDate"
                        type="date"
                        id="startDate"
                        class="px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out"
                    />
                </div>

                <div class="flex flex-col w-full md:w-auto">
                    <label for="endDate" class="mb-1 text-gray-700 font-medium">End Date</label>
                    <input
                        v-model="endDate"
                        type="date"
                        id="endDate"
                        class="px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out"
                    />
                </div>

                <div class="flex flex-col w-full md:w-auto">
                    <label for="currency" class="mb-1 text-gray-700 font-medium">Currency</label>
                    <select v-model="currency" id="currency" class="px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out">
                        <option value="">Select Currency</option>
                        <option v-for="curr in currencies" :key="curr.id" :value="curr.currency_code">{{ curr.currency_code }}</option>
                    </select>
                </div>

                <div class="flex flex-col w-full md:w-auto">
                    <label for="type" class="mb-1 text-gray-700 font-medium">Type</label>
                    <select v-model="type" id="type" class="px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out">
                        <option value="">Select Type</option>
                        <option v-for="typ in trans_types" :key="typ.type" :value="typ.type">{{ typ.type }}</option>
                    </select>
                </div>
                <div class="flex flex-col w-full md:w-auto">
                    <div class="mt-6">
                        <button
                            @click="exportPdf"
                            class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-300 ease-in-out"
                        >
                            Export to PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div
                v-for="sum in totals"
                :key="sum.currency"
                class="p-6 bg-white rounded-lg shadow-md transform transition duration-300 hover:scale-105">
                <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ sum.currency }}</h3>
                <p class="text-3xl font-bold text-blue-600">${{ sum.total_amount }}</p>
            </div>
        </div>

        <!-- Sales Table -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
                        <th scope="col" class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th scope="col" class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th scope="col" class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cashier</th>
                        <th scope="col" class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                        <th scope="col" class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="sale in sales.data" :key="sale.id">
                        <td class="py-4 px-6 text-sm font-medium text-gray-900">{{ sale.reference }}</td>
                        <td class="py-4 px-6 text-sm text-gray-500">${{ sale.amount }}</td>
                        <td class="py-4 px-6 text-sm text-gray-500">{{ sale.type }}</td>
                        <td class="py-4 px-6 text-sm text-gray-500">{{ sale.name }}</td>
                        <td class="py-4 px-6 text-sm text-gray-500">{{ sale.created_at }}</td>
                        <td class="py-4 px-6 text-sm font-medium">
                            <Button @click="showItemsModal(sale)" type="button" class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-eye"></i>
                                show items
                            </Button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <Pagination :links="sales.links" />
        <!-- Modal -->
        <div v-if="isModalVisible" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-1/2 p-6">
                <!-- Modal Header -->
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold">Sale Details</h2>
                    <button
                        @click="closeModal"
                        class="text-gray-500 hover:text-gray-800"
                    >
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <!-- Sale Information -->
                <div class="bg-gray-100 p-4 rounded-lg shadow-sm mb-6">
                    <p class="text-sm text-gray-600">
                        <span class="font-semibold text-gray-800">Reference:</span> {{ selectedSale.reference }}
                    </p>
                    <p class="text-sm text-gray-600">
                        <span class="font-semibold text-gray-800">Total Amount:</span> ${{ selectedSale.amount }}
                    </p>
                    <p class="text-sm text-gray-600">
                        <span class="font-semibold text-gray-800">Currency:</span> {{ selectedSale.currency }}
                    </p>
                    <p class="text-sm text-gray-600">
                        <span class="font-semibold text-gray-800">Cashier:</span> {{ selectedSale.name }}
                    </p>
                    <p class="text-sm text-gray-600">
                        <span class="font-semibold text-gray-800">Date:</span> {{ selectedSale.created_at }}
                    </p>
                </div>

                <!-- Items Sold -->
                <ul class="divide-y divide-gray-200 bg-white shadow-md rounded-lg">
                    <li
                        v-for="item in selectedSaleItems"
                        :key="item.id"
                        class="flex items-center justify-between p-4 hover:bg-gray-50"
                    >
                        <!-- Item Details -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">{{ item.item.name }}</h3>
                            <p class="text-sm text-gray-500">Quantity: {{ item.qty }} | Unit Price: ${{ item.unit_price }}</p>
                        </div>
                        <!-- Total Price -->
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Total:</p>
                            <p class="text-lg font-bold text-blue-600">${{ item.total_price }}</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</template>

<script>
import Layout from "../Shared/Layout.vue";
import Pagination from "../Shared/Components/Pagination.vue";
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import SuccessAlert from "../Shared/Components/SuccessAlert.vue";
import ErrorAlert from "../Shared/Components/ErrorAlert.vue";

export default {
    layout: Layout,
    props: {
        sales: Array,
        currencies: Array,
        trans_types: Array,
        cashiers: Array,
        totals: Array
    },
    components: {
        Pagination, SuccessAlert, ErrorAlert
    },
    setup() {
        const startDate = ref('');
        const endDate = ref('');
        const currency = ref('');
        const type = ref('');
        const cashier = ref('');
        //
        const isModalVisible = ref(false);
        const selectedSale = ref({});
        const selectedSaleItems = ref([]);

        const exportPdf = () => {
                const params = new URLSearchParams({
                start_date: startDate.value || '',
                end_date: endDate.value || '',
                currency: currency.value || '',
                type: type.value || '',
                cashier: cashier.value || '',
            }).toString();

            // Open the generated URL in a new browser window for download
            window.location.href = `/exportpdf?${params}`
        };

        watch([startDate, endDate, currency, type, cashier], () => {
            router.get('/cashier-reports', {
                start_date: startDate.value,
                end_date: endDate.value,
                currency: currency.value,
                type: type.value,
                cashier: cashier.value
            }, {
                preserveState: true,
                preserveScroll: true,
                replace: true
            });
        });

        const showItemsModal = (sale) => {
            selectedSale.value = sale; // Set the selected sale details
            selectedSaleItems.value = sale.items || []; // Set the items for this sale
            isModalVisible.value = true;
        };

        const closeModal = () => {
            isModalVisible.value = false;
        };

        return {
            startDate,
            endDate,
            currency,
            type,
            cashier,
            exportPdf,
            isModalVisible,
            selectedSale,
            selectedSaleItems,
            showItemsModal,
            closeModal,
        };
    },
};
</script>
