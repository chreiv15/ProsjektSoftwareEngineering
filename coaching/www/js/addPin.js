function addPin() {
    var userId = window.location.search.substring(3);
    
    $.post("../../../ajax/addPassword.php", {
        function: 'function', 
        id: userId,
        pin: $("#pin").val()
    }, function(data) {
        console.log(data);
        window.location = '../addsession/';
    });
    
}