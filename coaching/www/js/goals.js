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

function getFormerGoals() {
    $.post("../../../ajax/getFormerGoals.php", {
            userId: login.id
        },
        function (data) {
            data = JSON.parse(data);
            console.log(data);
            for(var i=0;i<data.length;i++){
                var item = document.createElement('div');
                $(item).addClass('item');
                $(item).addClass('item-icon-left');
                $(item).html(data[i].category);
                var input = document.createElement('input');
                $(input).addClass('profile-input');
                $(input).prop('readonly', true);
                $(input).val('Kostnad: '+data[i].value+' kroner');
                $(item).append(input);
                $('#prior-list').append(item);
            }
        });
}
getFormerGoals();