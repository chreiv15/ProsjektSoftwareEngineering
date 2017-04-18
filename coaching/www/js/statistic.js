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

$.post("http://fredrikhagen.no/westerdals/gruppe19/ajax/getSprintArchive.php",
{
    userId: login.id
},
function(data) {
    data = JSON.parse(data);
    console.log(data);
    var won = 0;
    var lost = 0;
    var result = 0;
    for(var i=0;i<data.length;i++){
        result = result + parseFloat(data[i].result);
        if(data[i].result >= data[i].value){
            won++;
        }else{
            lost++;
        }
        $("#session-count").html(data.length);
        $("#success-count").html(won);
        $("#failure-count").html(lost);
        $("#total-save-count").html(result);
    }
});