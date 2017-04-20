console.log('Hello world login');

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
    $.post("http://fredrikhagen.no/westerdals/gruppe19/ajax/getUser.php", {
            user: $('#email').val(),
            pin: $('#pin').val()
        },
        function (data, status) {
            data = JSON.parse(data);
            console.log(data);
            localStorage.setItem("login", JSON.stringify(data));
            window.location = 'home/index.html';
        });
}