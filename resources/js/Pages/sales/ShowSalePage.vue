<template>
    <Head title="Sale Details"/>
    <div class="max-w-7xl mx-auto p-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Sale Details</h1>

        <SuccessAlert v-if="$page.props.errors.success" :message="$page.props.errors.success" />
        <ErrorAlert v-if="$page.props.errors.error" :message="$page.props.errors.error" />

        <!-- Sale Information Card -->
        <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Sale Information</h2>
            <table class="min-w-full divide-y divide-gray-200">
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-gray-500">Sale ID</th>
                        <td class="px-6 py-4 text-gray-900">{{ sale.id }}</td>
                    </tr>
                    <tr>
                        <th class="px-6 py-3 text-left text-gray-500">Cashier</th>
                        <td class="px-6 py-4 text-gray-900">{{ sale.cashier }}</td>
                    </tr>
                    <tr>
                        <th class="px-6 py-3 text-left text-gray-500">Sale Cash</th>
                        <td class="px-6 py-4 text-gray-900">${{ sale.sale_cash }}</td>
                    </tr>
                    <tr>
                        <th class="px-6 py-3 text-left text-gray-500">Sale Change</th>
                        <td class="px-6 py-4 text-gray-900">${{ sale.sale_change }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Sale Items Card -->
        <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Sale Items</h2>
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-gray-500">Item Name</th>
                        <th class="px-6 py-3 text-left text-gray-500">Quantity</th>
                        <th class="px-6 py-3 text-left text-gray-500">Price</th>
                        <th class="px-6 py-3 text-left text-gray-500">Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="item in sale_items" :key="item.id">
                        <td class="px-6 py-4 text-gray-900">{{ item.name }}</td>
                        <td class="px-6 py-4 text-gray-900">{{ item.quantity }}</td>
                        <td class="px-6 py-4 text-gray-900">${{ item.price }}</td>
                        <td class="px-6 py-4 text-gray-900">${{ item.total }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- EFT Transactions Card -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">EFT Transactions</h2>
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-gray-500">Transaction ID</th>
                        <th class="px-6 py-3 text-left text-gray-500">Transaction Type</th>
                        <th class="px-6 py-3 text-left text-gray-500">Amount</th>
                        <th class="px-6 py-3 text-left text-gray-500">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="transaction in eft_transactions" :key="transaction.id">
                        <td class="px-6 py-4 text-gray-900">{{ transaction.id }}</td>
                        <td class="px-6 py-4 text-gray-900">{{ transaction.type }}</td>
                        <td class="px-6 py-4 text-gray-900">${{ transaction.amount }}</td>
                        <td class="px-6 py-4 text-gray-900">{{ transaction.date }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import SuccessAlert from '../../Shared/Components/SuccessAlert.vue';
import ErrorAlert from '../../Shared/Components/ErrorAlert.vue';

export default {
    props: {
        sale: Object,
        sale_items: Array,
        eft_transactions: Array
    },
    components: {
        SuccessAlert,
        ErrorAlert
    },
    setup(props) {
        const saleDetails = ref({ ...props.sale });
        const saleItems = ref([...props.sale_items]);
        const eftTransactions = ref([...props.eft_transactions]);

        return {
            saleDetails,
            saleItems,
            eftTransactions
        };
    }
}
</script>
