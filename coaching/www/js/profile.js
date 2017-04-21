console.log('hello!');

readLogin();
$("#user-email").val(login.email);
$("#user-account").val(login.accountId);

$("#logoutBtn").click(function(){
    console.log('Logout');
    localStorage.clear();
    window.location = '../index.html';
});