console.log('Hello world login'); 

$("#submit").click(function(){
    submit();
});

document.onkeypress = function (e) {
    e = e || window.event;
    if(e.key=="Enter") {
        submit();
    }
};

function submit(){
    $.post("../../../ajax/getUser.php",
    {
        user: $('#email').val(),
        pin: $('#pin').val()
    },
    function(data, status){
        console.log(data);
        window.location = './home/';
    });
}