<template>
    <Head title="Sales" />
    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="flex flex-col lg:flex-row justify-between items-center mb-8 p-6 bg-white rounded-lg shadow-md">
            <h1 class="text-4xl font-semibold text-gray-900 mb-4 lg:mb-0">Sales Records</h1>
            <div class="flex flex-wrap items-center space-x-4">
                <input
                    v-model="search"
                    type="search"
                    placeholder="Search by reference..."
                    class="w-full md:w-64 px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out"
                />
                <input
                    v-model="startDate"
                    type="date"
                    class="px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out"
                />
                <input
                    v-model="endDate"
                    type="date"
                    class="px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out"
                />
                <select v-model="currency" class="px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out">
                    <option value="">Select Currency</option>
                    <option v-for="curr in currencies" :key="curr.id" :value="curr.currency_code">{{ curr.currency_code }}</option>
                </select>
                <select v-model="type" class="px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out">
                    <option value="">Select Type</option>
                    <option v-for="typ in trans_types" :key="typ.type" :value="typ.type">{{ typ.type }}</option>
                </select>
            </div>
        </div>


        <!-- Existing SuccessAlert and ErrorAlert code -->

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
        currencies: Array, // Prop for available currencies
        trans_types: Array // Prop for available types
    },
    components: {
        Pagination, SuccessAlert, ErrorAlert
    },
    setup() {
        const search = ref('');
        const startDate = ref('');
        const endDate = ref('');
        const currency = ref('');
        const type = ref('');

        watch([search, startDate, endDate, currency, type], () => {
            router.get(
                '/sales',
                { search: search.value, start_date: startDate.value, end_date: endDate.value, currency: currency.value, type: type.value },
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true
                }
            );
        });

        return {
            search,
            startDate,
            endDate,
            currency,
            type,
        };
    },
}
</script>
