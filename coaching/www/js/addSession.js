var session = "";
var goal = "";

function setGoal(id) {    
    switch(id) {
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
    $.post("../../../ajax/getCategories.php", {
    },
    function(data){
        data = JSON.parse(data);
        console.log(data);
        for(var i=0;i<data.length;i++){
            
            var item = document.createElement('div');
            item.onclick = addGoal;
            item.id = id;
            item.className = "item item-icon-left text-left";
            item.innerHTML = data[i].name;
            $("#session-goal").append(item);
            
        }
    });
}

function addGoal(id) {
        switch(id) {
        case 0:
            goal = "NA";
            break;
            
        case 1:
            goal = "travel";
            break;
            
        case 2:
            goal = "food";
            break;
            
        case 3:
            goal = "lifestyle";
            break;
            
        case 4:
            goal = "electronics";
            break;
            
        default:
            goal = "undefined";
            break;
    }
    
    $("#step2").removeClass("show");
    $("#step2").addClass("hide");    
    $("#step3").addClass("show");    
}