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
    $.post("http://tek.westerdals.no/~hagfre15/hagfre15.2015.tek.westerdals.no/web/gruppe19/ajax/getUser.php",
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