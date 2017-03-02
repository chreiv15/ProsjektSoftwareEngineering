function startGoal(id) {
    var session = "";
    
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
    
    $("#add-goal").addClass("hide");
    $("#test").addClass("show");
    
}