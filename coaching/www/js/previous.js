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
        sprintId: 10
    },
    function(data) {
        data = JSON.parse(data);
        console.log(data);
        window.sprint = data;
        $('#savedAmount').html('Du sparte '+(sprint['sprintTarget'])+' kr')
    });
}
getFormerSprint();

google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Task', 'Forbruk'],
      ['Forbruk', sprint['sprintSpending']],
      ['Spart', sprint['sprintTarget']]
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