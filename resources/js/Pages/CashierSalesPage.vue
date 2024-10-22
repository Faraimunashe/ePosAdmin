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
                            class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-300 ease-in-out"
                        >
                            Export to PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div
                v-for="sum in totals"
                :key="sum.currency"
                class="p-6 bg-white rounded-lg shadow-md transform transition duration-300 hover:scale-105">
                <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ sum.currency }}</h3>
                <p class="text-3xl font-bold text-blue-600">${{ sum.total_amount }}</p>
            </div>
        </div>

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
                            <Link :href="'/sales/' + sale.id" class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-eye"></i>
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <Pagination :links="sales.links" />
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

        watch([startDate, endDate, currency, type, cashier], () => {
            router.get(
                '/cashier-reports',
                { start_date: startDate.value, end_date: endDate.value, currency: currency.value, type: type.value, cashier: cashier.value },
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true
                }
            );
        });

        return {
            startDate,
            endDate,
            currency,
            type,
            cashier,
        };
    },
}
</script>
