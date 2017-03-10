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
    $.post("http://fredrikhagen.no/westerdals/gruppe19/ajax/getUser.php",
    {
        user: $('#email').val(),
        pin: $('#pin').val()
    },
    function(data, status){
        console.log(data);
        alert(data, status);
        window.location = '../home/index.html';
    });
}