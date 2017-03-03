var session = "";
var goalID;
var goalName;
var goalCategoryName;
var hasGoal = false;

function checkSession() {
    alert("Dette vil overskrive din nåværende økt");
}

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
            window.categoryList = data;
            for (var i = 0; i < data.length; i++) {
                var item = document.createElement('div');
                item.onclick = addGoal;
                item.id = data[i].id;
                item.className = "item item-icon-left text-left";
                item.innerHTML = data[i].name;
                $("#session-goal").append(item);
                $(item).click(function(){
                    window.goalCategory = this.id;
                    window.goalCategoryName = this.innerHTML;
                    addGoal(goalCategory);
                });
            }
        }
    );
}

function addGoal(category) {
    category = parseInt(category)-10;
    $("#step2").removeClass("show");
    $("#step2").addClass("hide");
    $("#step3").addClass("show");
    
    if (hasGoal) {
        $("#has-goal").append("<div class='item item-icon-left'>Du har valgt "+categoryList[category]['name'].toLowerCase()+"</div>");
        $("#has-goal").append("<div class='item item-icon-left'>Skriv inn navnet på ditt sparemål<input type='text' class='profile-input' id='session-goalname' placeholder='f.eks "+categoryList[category]['example']+"' /></div>");
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
    $.post("../../../ajax/addSprint.php", {
        userId: login.id,
        sprintGoal: $("#session-savings").val(),
        beforeSpending: login.beforeSpending,
        goalName: $("#session-goalname").val(),
        goalValue: $("#session-goalvalue").val(),
        goalCategory: goalCategory,
        goalTargetDate: goalTargetDate
    },function(data) {
        window.sprintId = data.trim();
        console.log(sprintId);
        //window.location = '../addsession/';
    });
}

function getTargetDate(){
    var goalValue = $('#session-goalvalue').val();
    goalValue = parseFloat(goalValue);
    var sessionGoal = $('#session-savings').val();
    sessionGoal = parseFloat(sessionGoal);
    var due = goalValue / sessionGoal;
    var days = parseInt(due*30);
    var target = new Date();
    target.addDays(days);
    window.goalTargetDate = target.getFullYear()+'-'+target.getMonth()+'-'+target.getDate();
    $('#session-goaltargetdate').val(target.getDate()+'/'+target.getMonth()+'/'+target.getFullYear());
}

Date.prototype.addDays = function(days) {
    this.setDate(this.getDate() + parseInt(days));
    return this;
};

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            var s = c.substring(name.length, c.length);
            s = decodeURIComponent(s);
            s = JSON.parse(s);
            return s;
        }
    }
    return "";
}

function readLogin(){
    
    login = getCookie("login");
    login['id'] = parseInt(login['id']);
    login['goalId'] = parseInt(login['goalId']);
    login['goalValue'] = parseFloat(login['goalValue']);
    login['beforeSpending'] = parseFloat(login['beforeSpending']);
    login['accountValue'] = parseFloat(login['accountValue']);
    login['accountId'] = parseInt(login['accountId']);
    login['sprintId'] = parseInt(login['sprintId']);
    window.login = login;
    $('#user-name').html(login.firstname+' '+login.lastname);
}
readLogin();