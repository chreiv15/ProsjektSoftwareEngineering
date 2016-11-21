<?php

$user = 5201000;


?>
<head>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        p,a,input,label {
            font-family: sans-serif;
            font-size: 16px;
        }
        input, img {
            display: block;
            margin-bottom: 10px;
        }
        input {
            padding: 5px;
            width: 50px;
            border: none;
            display: inline-block;
        }
        .box {
            display: inline-block;
            text-align: center;
        }
        .material-icons {
            font-size: 150px;
            cursor: pointer;
        }
        main {
            text-align: center;
            margin-top: 25px;
        }
    </style>
    <script>
        var account = 97348898349;
        function buy(){
            document.getElementById("result").innerHTML = "<p>Kjøper...</p>";
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
        function submit(desc,price,catg,account){
            console.log(desc+" til "+price+" kr, kategori "+catg);
            if (window.XMLHttpRequest) {
                xmlhttp=new XMLHttpRequest();
            }
            xmlhttp.onreadystatechange=function() {
                if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                    document.getElementById("result").innerHTML=xmlhttp.responseText;
                }
            }
            var url = "../ajax/addTransaction.php?description="+desc+"&value="+price+"&category="+catg+"&account="+account;
            console.log(url);
            xmlhttp.open("GET",url,true);
            xmlhttp.send();
        }
    </script>
</head>

<main>
    <div id="info"></div>
    <div class="box" id="grc">
        <i class="material-icons">shopping_cart</i>
        <p>Dagligvarer</p>
        <label for="grc">kr</label>
        <input step="5" min="0" id="grc" type="number" value="500">
    </div>
    <div class="box" id="cof">
        <i class="material-icons">local_cafe</i>
        <p>Kaffe</p>
        <label for="cof">kr</label>
        <input step="5" min="0" id="cof" type="number" value="20">
    </div>
    <div class="box" id="kaf">
        <i class="material-icons">local_dining</i>
        <p>Kafeteria</p>
        <label for="kaf">kr</label>
        <input step="5" min="0" id="kaf" type="number" value="45">
    </div>
    <div class="box" id="drk">
        <i class="material-icons">local_bar</i>
        <p>Drinker</p>
        <label for="drk">kr</label>
        <input step="5" min="0" id="drk" type="number" value="90">
    </div>
    <div class="box" id="dlv">
        <i class="material-icons">local_pizza</i>
        <p>Matlevering</p>
        <label for="dlv">kr</label>
        <input step="5" min="0" id="dlv" type="number" value="400">
    </div>
    <div id="result"></div>
</main>
<script>

    var boxes = document.getElementsByClassName("box");
    
    for(var i=0;i<boxes.length;i++){
        var nodes = boxes[i].childNodes;
        nodes[1].onclick = buy;
    }
    var info = document.getElementById("info");
    info.innerHTML = "<p>Konto: "+account+"</p>";

</script>