function addUser() {
    
    $.post("http://fredrikhagen.no/westerdals/gruppe19/ajax/addUser.php", {
        function: 'function', 
        fname: $("#f-name").val(),
        lname: $("#l-name").val(),
        email: $("#email").val()
    }, function(data) {
        console.log(data);
        
        window.location = "../newpin/index.html?u=" + data;
    });
    
}