function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            var s = c.substring(name.length, c.length);
            s = decodeURIComponent(s);
            s = JSON.parse(s);
            return s;
        }
    }
    return "";
}

function readLogin(){
    
    login = getCookie("login");
    login['id'] = parseInt(login['id']);
    login['goalId'] = parseInt(login['goalId']);
    login['goalValue'] = parseFloat(login['goalValue']);
    login['beforeSpending'] = parseFloat(login['beforeSpending']);
    login['accountValue'] = parseFloat(login['accountValue']);
    login['accountId'] = parseInt(login['accountId']);
    login['sprintId'] = parseInt(login['sprintId']);
    window.login = login;
    $('#user-name').html(login.firstname+' '+login.lastname);
}
readLogin();

function getFormerSprint() {
    $.post("../../../ajax/getFormerSprint.php",
    {
        userId: login.id,
        sprintId: location.search.substr(4)
    },
    function(data) {
        data = JSON.parse(data);
        console.log(data);
        window.sprint = data;
        sprint.goalValue = parseFloat(sprint.goalValue);
        sprint.sprintSpending = parseFloat(sprint.sprintSpending);
        sprint.sprintTarget = parseFloat(sprint.sprintTarget);
        
        $('#savedAmount').html('Du sparte '+(login.beforeSpending-sprint.sprintSpending)+' kr');
        $('#period').html(data.sprintStart+' - '+data.sprintEnd);
        $('#setSpending').html('Du hadde avsatt forbruk på '+(login.beforeSpending-data.sprintTarget)+',-');
    });
}
getFormerSprint();

google.charts.load("current", {packages:["corechart"]});
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
            0: { color: '#ff8a00' },
            1: { color: '#efefef' }
        }
    };

    var chart = new google.visualization.PieChart(document.getElementById('pie-chart'));
    chart.draw(data, options);
}