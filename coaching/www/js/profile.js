console.log('hello!');

readLogin();
$("#user-email").val(login.email);
$("#user-account").val(login.accountId);

$("#deleteBtn").click(function(){
    x = confirm('Er du sikker på at du vil slettte brukeren?');
    if(x == true){
        localStorage.clear();
        window.location = '../index.html';
    }
});

$("#logoutBtn").click(function(){
    x = confirm('Er du sikker på at du vil logge ut?');
    if(x == true){
        console.log('Logout');
        localStorage.clear();
        window.location = '../index.html';
    }
});