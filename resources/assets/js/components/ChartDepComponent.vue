<template>
 
    <canvas id="ftthDepartement-chart"></canvas>
  
</template>
<script>
import ftthDepartementData from '../ftthDepartement-data.js';
import Chart from 'chart.js';
export default {
  methods: {
  createChart(chartId, chartData) {
    const ctx = document.getElementById(chartId);
    const myChart = new Chart(ctx, {
      type: chartData.type,
      data: chartData.data,
      options: chartData.options,
    });
  }
},
  mounted() {
    this.createChart('ftthDepartement-chart', this.ftthDepartementData);
  },
  name: 'app',
  data() {
    return {
      ftthDepartementData: ftthDepartementData,
    }
  }
}
</script>

<style scoped>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}

h1, h2 {
  font-weight: normal;
}

ul {
  list-style-type: none;
  padding: 0;
}

li {
  display: inline-block;
  margin: 0 10px;
}

a {
  color: #42b983;
}
</style>

