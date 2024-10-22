<template>
    <div>
      <Pie :data="chartData" :options="chartOptions" />
    </div>
  </template>

  <script setup>
  import { defineProps } from 'vue';
  import { Pie } from 'vue-chartjs';
  import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement } from 'chart.js';

  ChartJS.register(Title, Tooltip, Legend, ArcElement);

  const props = defineProps({
    chartData: Object,
    chartOptions: Object
  });
  </script>
