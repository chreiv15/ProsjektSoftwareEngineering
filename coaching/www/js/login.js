console.log('Hello world! #login');

localStorage.clear();

$("#submit").click(function () {
    submit();
});

document.onkeypress = function (e) {
    e = e || window.event;
    if (e.key == "Enter") {
        submit();
    }
};

function submit() {
    console.log('Submit');
    $.post("http://fredrikhagen.no/westerdals/gruppe19/ajax/getUser.php", {
        user: $('#email').val(),
        pin: $('#pin').val()
    },
    function (data, status) {
        console.log(status);
        if(data != "ERROR"){
            data = JSON.parse(data);
            console.log(data);
            localStorage.setItem("login", JSON.stringify(data));
            window.location = 'home/index.html';
        }else{
            alert('Feil brukernavn eller pin.');
        }
    });
}

function getObject() {
    var data = localStorage.getItem('login');
    console.log(JSON.parse(data));
}