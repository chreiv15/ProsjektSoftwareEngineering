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

function getCurrentSprint() {
    $.post("../../../ajax/getCurrentSprint.php",
    {
        userId: login.id
    },
    function(data) {
        data = JSON.parse(data);
        window.sprint = data;
        console.log(sprint);
        if(((login.beforeSpending-sprint.sprintTarget)-sprint.sprintSpending)>0){
            $(".fin-form h3").html('Gratulerer!');
            $("#result-text").html('Du klarte ditt sparemål.');
        }else{
            $(".fin-form h3").html('Lykke til neste gang');
            $("#result-text").html('Du nådde ikke ditt sparemål.');
        }
        $("#spending-text").html('Du brukte '+sprint.sprintSpending+'/'+(login.beforeSpending-sprint.sprintTarget)+' av ditt forbruk.');
        $("#badge-text").html('Du er ubrukelig.');
        var saved = login.beforeSpending-sprint.sprintSpending;
        var sprintId = sprint.id;
        setFinishedSprint(saved, sprintId);
    });
}
getCurrentSprint();

function setFinishedSprint(saved, sprintId) {
    console.log(sprintId);
    console.log(saved);
    $.post("../../../ajax/setFinishedSprint.php",
    {
        sprintId: sprintId,
        saved: saved
    },
    function(data) {
        //data = JSON.parse(data);
        console.log(data);
    });
}
