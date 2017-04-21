var session = "";
var goalID;
var goalName;
var goalCategoryName;
var hasGoal = false;
var step = 1;

function getLocalStorage(name) {
    var data = localStorage.getItem(name);
    data = JSON.parse(data);
    console.log(data);
    return data;
}

function readLogin() {

    login = getLocalStorage("login");
    login['id'] = parseInt(login['id']);
    login['goalId'] = parseInt(login['goalId']);
    login['goalValue'] = parseFloat(login['goalValue']);
    login['beforeSpending'] = parseFloat(login['beforeSpending']);
    login['accountValue'] = parseFloat(login['accountValue']);
    login['accountId'] = parseInt(login['accountId']);
    login['sprintId'] = parseInt(login['sprintId']);
    window.login = login;
    $('#user-name').html(login.firstname + ' ' + login.lastname);
}
readLogin();

function checkSession() { // MÅ FULLFØRES
    $.post("http://fredrikhagen.no/westerdals/gruppe19/ajax/getActiveSprints.php",
    {
        id: login.id
    },
    function (data) {
        if(data.trim()!='false'){
            var x = confirm("Dette vil overskrive din nåværende økt");
            if(x == true){
                console.log(data);
                $.post("http://fredrikhagen.no/westerdals/gruppe19/ajax/deleteCurrentSprint.php",
                {
                    id: data
                },
                function (data) {
                    console.log(data);
                });
            }else{
                window.location = "../home/index.html";
            }
        }
    });
}
checkSession();

function goBack() {
    switch (step) {
        case 1:
            window.location = "../home/index.html";
            break;
        
        case 2:
            step = 1;
            $("#step2").removeClass("show");
            $("#step2").addClass("hide");
            $("#step1").addClass("show");
            break;
        
        case 3:
            step = 2;
            $("#step3").removeClass("show");
            $("#step3").addClass("hide");
            $("#step2").addClass("show");
            break;
        
        default:
            break;
    }
}

function setGoal(id) {
    step = 2;
    
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

    $("#step1").removeClass("show");
    $("#step1").addClass("hide");
    $("#step2").addClass("show");
}

function wantGoal() {
    
    hasGoal = true;

    $("#session-goal").addClass("show");

    $.post("http://fredrikhagen.no/westerdals/gruppe19/ajax/getCategories.php", {},
        function (data) {
            data = JSON.parse(data);
            window.categoryList = data;
            for (var i = 0; i < data.length; i++) {
                var item = document.createElement('div');
                item.onclick = addGoal;
                item.id = data[i].id;
                item.className = "item item-icon-left text-left";
                item.innerHTML = data[i].name;
                item.innerHTML += '<i class="fa '+data[i].icon+'" aria-hidden="true"></i>';
                $("#session-goal").append(item);
                $(item).click(function () {
                    window.goalCategory = this.id;
                    window.goalCategoryName = this.innerHTML;
                    addGoal(goalCategory);
                });
            }
        }
    );
}

function addGoal(category) {
    step = 3;
    
    category = parseInt(category) - 10;
    $("#step2").removeClass("show");
    $("#step2").addClass("hide");
    $("#step3").addClass("show");

    if (hasGoal) {
        $("#has-goal").append("<div class='item item-icon-left'>Du har valgt " + categoryList[category]['name'].toLowerCase() + "</div>");
        $("#has-goal").append("<div class='item item-icon-left'>Skriv inn navnet på ditt sparemål<input type='text' class='profile-input' id='session-goalname' placeholder='f.eks " + categoryList[category]['example'] + "' /></div>");
        $("#has-goal").append("<div class='item item-icon-left'>Hva koster sparemålet?<input type='text' class='profile-input' id='session-goalvalue' placeholder='f.eks 8000' / onkeyup='getTargetDate()'></div>");
        $("#has-goal").append("<div class='item item-icon-left'>Du vil nå målet innen<input type='text' class='profile-input' id='session-goaltargetdate' readonly /></div>");
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
    console.log("Start session");
    $.post("http://fredrikhagen.no/westerdals/gruppe19/ajax/addSprint.php", {
        userId: login.id,
        sprintGoal: $("#session-savings").val(),
        beforeSpending: login.beforeSpending,
        goalName: $("#session-goalname").val(),
        goalValue: $("#session-goalvalue").val(),
        goalCategory: goalCategory,
        goalTargetDate: goalTargetDate
    }, function (data) {
        console.log('Response');
        window.sprintId = data.trim();
        console.log('SprintID: '+sprintId);
        window.location = '../home/index.html';
    });
}

function getTargetDate() {
    var goalValue = $('#session-goalvalue').val();
    goalValue = parseFloat(goalValue);
    var sessionGoal = $('#session-savings').val();
    sessionGoal = parseFloat(sessionGoal);
    var due = goalValue / sessionGoal;
    var days = parseInt(due * 30);
    var target = new Date();
    target.addDays(days);
    window.goalTargetDate = target.getFullYear() + '-' + target.getMonth() + '-' + target.getDate();
    $('#session-goaltargetdate').val(target.getDate() + '/' + target.getMonth() + '/' + target.getFullYear());
}

Date.prototype.addDays = function (days) {
    this.setDate(this.getDate() + parseInt(days));
    return this;
};