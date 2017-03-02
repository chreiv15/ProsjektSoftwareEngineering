var session = "";
var goalID;
var goalName;

var hasGoal = false;

function setGoal(id) {
    switch (id) {
        case 1:
            session = "clothes";
            break;

        case 2:
            session = "food";
            break;

        case 3:
            session = "lifestyle";
            break;

        case 4:
            session = "electronics";
            break;

        default:
            session = "undefined";
            break;
    }

    $("#step1").addClass("hide");
    $("#step2").addClass("show");
}

function wantGoal() {
    hasGoal = true;
    
    $("#session-goal").addClass("show");

    $.post("../../../ajax/getCategories.php", {},
        function (data) {
            data = JSON.parse(data);
            console.log(data);
            for (var i = 0; i < data.length; i++) {

                var item = document.createElement('div');
                item.onclick = addGoal;
                item.id = data[i].id;
                item.className = "item item-icon-left text-left";
                item.innerHTML = data[i].name;
                $("#session-goal").append(item);

            }
        }
    );
}

function addGoal(id) {
    goal = id;

    $("#step2").removeClass("show");
    $("#step2").addClass("hide");
    $("#step3").addClass("show");
    
    if (hasGoal) {
        $("#has-goal").append("<div class='item item-icon-left'>Skriv inn navnet på ditt sparemål<input type='text' class='profile-input' id='session-goalname' placeholder='f.eks Playstation' /></div>");
    }
}

function setActive(button) {
    var btn = $(button);

    $(".active").removeClass("active");

    if (!btn.hasClass("active")) {
        btn.addClass("active");
    }
}

function startSesstion() {
    $.post("../../../ajax/addPassword.php", {
        function: 'function', 
        userId: 5201044,
        sprintGoal: 34,
        beforeSpending: 121,
        goalName: $("#session-goalname").val(),
        goalValue: $("#session-savings").val(),
        goalCategory: goal,
        goalTargetDate: 20
    }, function(data) {
        console.log(data);
        window.location = '../addsession/';
    });
    
}
