google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
var data = google.visualization.arrayToDataTable([
  ['Task', 'Forbruk'],
  ['Forbruk',     4000],
  ['Spart',     500]
]);

var options = {
    legend: 'none',
    pieHole: 0.75,
    pieSliceText: 'none',
    slices: {
        0: { color: '#ff8a00' },
        1: { color: '#efefef' }
    }
};

var chart = new google.visualization.PieChart(document.getElementById('pie-chart'));
chart.draw(data, options);
}