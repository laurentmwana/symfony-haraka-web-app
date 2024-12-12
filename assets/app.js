import ApexCharts from "apexcharts";
import "./bootstrap";
import "./js/base";

const pieChart = document.querySelector("#pie-apexchart");
if (pieChart) {
  const data = pieChart.dataset.pie;

  console.log(data);

  const chart = new ApexCharts(pieChart, {});

  chart.render();
}
