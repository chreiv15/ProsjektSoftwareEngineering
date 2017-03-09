function addPin() {
    var userId = window.location.search.substring(3);
    
    $.post("http://tek.westerdals.no/~hagfre15/hagfre15.2015.tek.westerdals.no/web/gruppe19/ajax/addPassword.php", {
        function: 'function', 
        id: userId,
        pin: $("#pin").val()
    }, function(data) {
        console.log(data);
        window.location = '../addsession/';
    });
    
}