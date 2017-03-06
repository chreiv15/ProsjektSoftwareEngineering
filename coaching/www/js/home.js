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

$("#prior").click(function(){
    console.log('Getting archive...');
    $.post("../../../ajax/getSprintArchive.php",
    {
        userId: login.id
    },
    function(data) {
        data = JSON.parse(data);
        console.log(data);
        $("#prior-list").html('');
        for(var i=0;i<data.length;i++){
            var item = document.createElement('a');
            item.className = 'item item-icon-left';
            item.href = '../previous/?id='+data[i].id;
            var icon = document.createElement('i');
            icon.className = 'fa fa-check-circle-o text-success';
            $(icon).attr('aria-hidden','true');
            $(item).append(icon);
            $(item).append('ØKT '+i);
            var date = document.createElement('span');
            date.className = 'item-note';
            date.innerHTML = data[i].sprintStart+' - '+data[i].sprintEnd;
            $("#prior-list").append(item);
        }
    });
});

// Value should be equal to days left in current sprint
document.getElementById("days-left").value = "15";