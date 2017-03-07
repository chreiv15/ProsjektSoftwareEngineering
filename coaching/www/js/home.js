function getCurrentSprint() {
    $.post("../../../ajax/getCurrentSprint.php",
    {
        userId: login.id
    },
    function(data) {
        var months = ['januar','februar','mars','april','mai','juni','juli','august','september','oktober','november','desember'];
        data = JSON.parse(data);
        console.log(data);
        var one_day=1000*60*60*24;
        var sprintEnd = new Date(data['sprintEnd']);
        var sprintStart = new Date(data['sprintStart']);
        var today = new Date();
        var sprintLength = sprintEnd - sprintStart;
        var sprintLength = Math.round(sprintLength/one_day);
        var currentDuration = today - sprintStart;
        var currentDuration = Math.round(currentDuration/one_day);
        var leftOfSprint = sprintLength - currentDuration;
        $("#days-left").attr('value',currentDuration);
        $("#days-left").attr('max',sprintLength);
        $("#leftOfSprint").html(leftOfSprint+' dager');
        $(".sprintTarget").html(data['sprintTarget']);
        $(".sprintSpending").html(data['sprintSpending']);
        $("#sprintStart").html('Startet '+sprintStart.getDate()+'. '+(months[sprintStart.getMonth()])+' '+sprintStart.getFullYear());
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