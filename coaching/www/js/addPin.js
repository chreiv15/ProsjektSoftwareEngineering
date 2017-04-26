function addPin() {
    var userId = window.location.search.substring(3);
    
    $.post("http://fredrikhagen.no/westerdals/gruppe19/ajax/addPassword.php", {
        function: 'function', 
        id: userId,
        pin: $("#pin").val()
    }, function(data) {
        console.log(data);
        data = JSON.parse(data);
        console.log(data);
        localStorage.setItem("login", JSON.stringify(data));
        window.location = '../addsession/index.html?new=1';
    });
}