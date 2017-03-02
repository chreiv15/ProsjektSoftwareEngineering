console.log('Hello world login'); 

$("#submit").click(function(){
    console.log('Submit'); 
    
    $.post("../../../../ajax/getUser.php",
    {
        user: $('#email').val(),
        pin: $('#pin').val()
    },
    function(data, status){
        console.log(data);
        window.location = './home/';
    });
    
});
