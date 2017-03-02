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
}

function addGoal(id) {
        switch(id) {
        case 0:
            session = "NA";
            break;
            
        case 1:
            session = "travel";
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
    
    $("#step2").removeClass("show");
    $("#step2").addClass("hide");    
    $("#step3").addClass("show");    
}