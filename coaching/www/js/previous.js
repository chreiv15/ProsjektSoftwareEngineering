function getLocalStorage(name) {
    var data = localStorage.getItem(name);
    data = JSON.parse(data);
    console.log(data);
    return data;
}

function readLogin() {

    login = getLocalStorage("login");
    login['id'] = parseInt(login['id']);
    login['goalId'] = parseInt(login['goalId']);
    login['goalValue'] = parseFloat(login['goalValue']);
    login['beforeSpending'] = parseFloat(login['beforeSpending']);
    login['accountValue'] = parseFloat(login['accountValue']);
    login['accountId'] = parseInt(login['accountId']);
    login['sprintId'] = parseInt(login['sprintId']);
    window.login = login;
    $('#user-name').html(login.firstname + ' ' + login.lastname);
}
readLogin();

function getFormerSprint() {
    $.post("http://fredrikhagen.no/westerdals/gruppe19/ajax/getFormerSprint.php", {
            userId: login.id,
            sprintId: location.search.substr(4)
        },
        function (data) {
            data = JSON.parse(data);
            console.log(data);
            window.sprint = data;
            sprint.goalValue = parseFloat(sprint.goalValue);
            sprint.sprintSpending = parseFloat(sprint.sprintSpending);
            sprint.sprintTarget = parseFloat(sprint.sprintTarget);

            $('#savedAmount').html('Du sparte ' + (login.beforeSpending - sprint.sprintSpending) + ' kr');
            $('#period').html(data.sprintStart + ' - ' + data.sprintEnd);
            $('#setSpending').html('Du hadde avsatt forbruk på ' + (login.beforeSpending - data.sprintTarget) + ',-');
        });
}
getFormerSprint();

google.charts.load("current", {
    packages: ["corechart"]
});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Task', 'Forbruk'],
      ['Forbruk', login.beforeSpending],
      ['Spart', parseFloat(sprint.sprintSpending)]
    ]);

    var options = {
        legend: 'none',
        pieHole: 0.75,
        pieSliceText: 'none',
        slices: {
            0: {
                color: '#ff8a00'
            },
            1: {
                color: '#efefef'
            }
        }
    };

    var chart = new google.visualization.PieChart(document.getElementById('pie-chart'));
    chart.draw(data, options);
}