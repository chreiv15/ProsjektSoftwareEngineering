var session = "";
var goal;

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
    $("#session-goal").addClass("show");
<<<<<<< HEAD
<<<<<<< HEAD
    $.post("../../../ajax/getCategories.php", {
    },
    function(data){
        data = JSON.parse(data);
        console.log(data);
        for(var i=0;i<data.length;i++){
            
            var item = document.createElement('div');
            item.onclick = addGoal;
            item.id = data[i].id;
            item.className = "item item-icon-left text-left";
            item.innerHTML = data[i].name;
            $("#session-goal").append(item);
            
        }
    });
=======
=======
>>>>>>> d2509d09974c143710a65e5bcf78befd98094503
    $.post("../../../ajax/getCategories.php", {},
        function (data) {
            data = JSON.parse(data);
            console.log(data);
            for (var i = 0; i < data.length; i++) {

                var item = document.createElement('div');
                item.onclick = addGoal;
<<<<<<< HEAD
                item.id = id;
=======
                item.id = data[i].id;
>>>>>>> d2509d09974c143710a65e5bcf78befd98094503
                item.className = "item item-icon-left text-left";
                item.innerHTML = data[i].name;
                $("#session-goal").append(item);

            }
        });
<<<<<<< HEAD
>>>>>>> 6d6112989985eed229e7d4e8de7f691ab0a7fba5
=======
>>>>>>> d2509d09974c143710a65e5bcf78befd98094503
}

function addGoal(id) {
    goal = id;

    $("#step2").removeClass("show");
    $("#step2").addClass("hide");
    $("#step3").addClass("show");
}

function setActive(button) {
    var btn = $(button);

    $(".active").removeClass("active");

    if (!btn.hasClass("active")) {
        btn.addClass("active");
    }
=======
function startSesstion() {
    
>>>>>>> d2509d09974c143710a65e5bcf78befd98094503
}

function getAccountFromId(id) {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            return xmlhttp.responseText;
        }
    }
    var url = "../ajax/getAccountFromId.php?id=" + id;
    console.log("URL: " + url);
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

function getUserInfo() {
    var config = readCookie("login");
    try {
        config = config.split('%7C');
    } catch (e) {
        console.log("Error");
    }
    var id = config[0];
    //document.getElementById("user-account").value = config[0];
    var firstname = config[2];
    var lastname = config[3];
    document.getElementById("user-name").innerHTML = config[1] + " " + config[2];
    var email = config[4];
    document.getElementById("user-email").value = decodeURIComponent(config[3]);
    var phone = config[5];
    document.getElementById("user-phone").value = config[4];
    var account = getAccountFromId(id);
    console.log("Account: " + account);
    document.getElementById("user-account").value = account;
    //return config;   
}

function readCookie(cname) {
    var allcookies = document.cookie;
    cookiearray = allcookies.split(';');
    for (var i = 0; i < cookiearray.length; i++) {
        var name = cookiearray[i].split('=')[0];
        if (name.trim() == cname) {
            var value = cookiearray[i].split('=')[1];
            break;
        }
    }
    return value;
}

getUserInfo();
