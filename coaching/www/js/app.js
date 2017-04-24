var pageIndex = 2;
showPage(pageIndex);

function plusPage(n) {
    showPage(pageIndex = n);
}
    
function showPage(n) {
    var i;
    var x = document.getElementsByClassName("page");
    if (n > x.length) {
        pageIndex = 1
    }
    if (n < 1) {
        pageIndex = x.length
    };
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }

    x[pageIndex - 1].style.display = "block";
}

function getLocalStorage(name) {
    var data = localStorage.getItem(name);
    data = JSON.parse(data);
    console.log(data);
    return data;
}

function readLogin() {
    console.log('Reading login...');
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