function addUser() {
    
    $.post("../../../ajax/addUser.php", {
        function: 'function', 
        fname: $("#f-name").val(),
        lname: $("#l-name").val(),
        email: $("#email").val()
    }, function(data) {
        console.log(data);
        
        window.location = "../newpin/?u=" + data;
    });
    
}