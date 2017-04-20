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
<<<<<<< HEAD
            user: $('#email').val(),
            pin: $('#pin').val()
        },
        function (data, status) {
            data = JSON.parse(data);
            console.log(data);
            localStorage.setItem("login", JSON.stringify(data));
            window.location = 'home/index.html';
        });
=======
        user: $('#email').val(),
        pin: $('#pin').val()
    },
    function (data, status) {
        data = JSON.parse(data);
        console.log(data);
        localStorage.setItem("login", JSON.stringify(data));
        alert('Velkommen, ' + data.firstname + '!');
        window.location = 'home/index.html';
    });
}

function getObject() {
    var data = localStorage.getItem('login');
    console.log(JSON.parse(data));
>>>>>>> origin/master
}