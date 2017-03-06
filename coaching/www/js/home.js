function getCurrentSprint() {
    $.post("../../../ajax/getCurrentSprint.php",
    {
        userId: login.id
    },
    function(data) {
        data = JSON.parse(data);
        console.log(data);
    });
}
getCurrentSprint();