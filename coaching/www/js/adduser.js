function addUser() {
    
    $.post("http://tek.westerdals.no/~hagfre15/hagfre15.2015.tek.westerdals.no/web/gruppe19/ajax/addUser.php", {
        function: 'function', 
        fname: $("#f-name").val(),
        lname: $("#l-name").val(),
        email: $("#email").val()
    }, function(data) {
        console.log(data);
        
        window.location = "../newpin/index.html?u=" + data;
    });
    
}