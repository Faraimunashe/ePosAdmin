<template>
    <Head title="Welcome"/>
    <div class="max-w-7xl mx-auto px-6 py-6">
        <!-- Page Header -->
        <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Welcome to ePOS Dashboard</h1>
            <p class="mt-2 text-gray-600">This is a blank starter page for you to build upon. You can add widgets, charts, and more!</p>
        </div>

        <!-- Counts Cards -->
        <CountCardsRow :counts="counts" />

        <!-- Page Content -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <div class="h-64 flex flex-col md:flex-row items-center justify-center gap-6">
                <!-- Sales by Currency Chart -->
                <div class="w-full md:w-1/2">
                    <BarChart :chartData="salesByCurrencyData" :chartOptions="chartOptions" />
                </div>

                <!-- Sales by Item Chart -->
                <div class="w-full md:w-1/2">
                    <BarChart :chartData="salesByItemData" :chartOptions="chartOptions" />
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
        counts: Object
    }
}
</script>

<script setup>
import { ref } from 'vue';
import BarChart from './Charts/BarChart.vue';

const salesByCurrencyData = ref({
  labels: ['USD', 'EUR', 'GBP'],
  datasets: [
    {
      label: 'Sales by Currency',
      data: [500, 300, 200],
      backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)'],
      borderColor: ['rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'],
      borderWidth: 1
    }
  ]
});

const salesByItemData = ref({
  labels: ['Item A', 'Item B', 'Item C'],
  datasets: [
    {
      label: 'Sales by Item',
      data: [150, 200, 50],
      backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)'],
      borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)'],
      borderWidth: 1
    }
  ]
});

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
