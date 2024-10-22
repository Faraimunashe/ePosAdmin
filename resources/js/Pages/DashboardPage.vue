<template>
    <Head title="Welcome"/>
    <div class="max-w-7xl mx-auto px-6 py-6">
        <!-- Page Header -->
        <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Welcome to ePOS Dashboard</h1>
            <p class="mt-2 text-gray-600">This is an overview of what is happening in your business!</p>
        </div>

        <!-- Counts Cards -->
        <CountCardsRow :counts="counts" />

        <div class="bg-white shadow-sm rounded-lg p-6">
            <div class="flex flex-col md:flex-row items-center justify-center gap-6">
                <div class="w-full md:w-1/2">
                    <BarChart :chartData="salesByCurrencyData" :chartOptions="chartOptions" />
                </div>

                <div class="w-full md:w-1/2 h-64 flex items-center justify-center">
                    <div class="w-full h-full">
                        <PieChart :chartData="salesByCurrencyData" :chartOptions="chartOptions" style="width: 100%; height: 100%;" />
                    </div>
                </div>
            </div>
        </div>




    </div>
</template>

<script>
import Layout from "../Shared/Layout.vue";
import CountCardsRow from './Dashboard/CountCardsRow.vue';

export default {
    layout: Layout,
    components: {
        CountCardsRow
    },
    props: {
        counts: Object,
        salesByCurrencyData: Object,
        salesByItemData: Object
    }
}
</script>

<script setup>
import { ref } from 'vue';
import BarChart from './Charts/BarChart.vue';
import PieChart from './Charts/PieChart.vue';

const chartOptions = ref({
  responsive: true,
  plugins: {
    legend: {
      position: 'top'
    },
    tooltip: {
      callbacks: {
        label: function(tooltipItem) {
          return `${tooltipItem.label}: ${tooltipItem.raw}`;
        }
      }
    }
  }
});
</script>
