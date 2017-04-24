
    var account = $("#accountNo").val();
    function buy(){
        document.getElementById("result").innerHTML = "<p>Kjøper...</p>";
        document.getElementById("registerSound").play();
        console.log("Buy "+this.parentNode.id);
        var nodes = this.parentNode.childNodes;
        var price = nodes[7].value;
        console.log(price+" kr");
        var ids = ['grc','cof','kaf','drk','dlv'];
        var catg = ids.indexOf(this.parentNode.id);
        var descriptions = ['Dagligvarer','Kaffe','Lunsj i kafeteria','Drinker/alkohol','Matlevering på døren'];
        var desc = descriptions[catg];
        console.log(desc);
        submit(desc,price,catg,account);
    }
    function submit(desc,price,catg){
        var account = $("#accountNo").val();
        console.log(desc+" til "+price+" kr, kategori "+catg);
        if (window.XMLHttpRequest) {
            xmlhttp=new XMLHttpRequest();
        }
        xmlhttp.onreadystatechange=function() {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                var result = document.getElementById("result");
                result.innerHTML=xmlhttp.responseText;
                setTimeout(function(){ result.innerHTML=""; }, 3000);
                getTransactions(account);
            }
        }
        var url = "../ajax/addTransaction.php?description="+desc+"&value="+price+"&category="+catg+"&account="+account;
        console.log(url);
        xmlhttp.open("GET",url,true);
        xmlhttp.send();
    }
    function getTransactions(account){
        $.post("../ajax/getTransactions.php", {
            account: account
        },
        function(data) {
            data = JSON.parse(data);
            console.log(data);

            $("#transactions tbody").html("");
            for(var i=0;i<data.length;i++){
                var row = document.createElement('tr');
                var nameCell  = document.createElement('td');
                var valueCell  = document.createElement('td');
                $(nameCell).html(data[i].description);
                $(valueCell).html(data[i].value);
                $(row).append(nameCell);
                $(row).append(valueCell);
                $("#transactions tbody").append(row);
            }
        });
    }
