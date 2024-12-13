import ApexCharts from "apexcharts";
import "./bootstrap";
import "./js/base";

const pieChart = document.querySelector("#pie-apexchart");

console.log(pieChart);
if (pieChart) {
  const data = JSON.parse(pieChart.dataset.pie);

  console.log(data);

  const chart = new ApexCharts(pieChart, {
    series: [data.student, data.checker],
    labels: ["Compte étudiant", "Compte vérificateur"],
    chart: {
      type: "donut",
    },
  });

  chart.render();
}
