<?php

$user = 5201000;

?>
<head>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        p,a,input,label,td,th {
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
        .material-icons:hover {
            color: darkslategray;
        }
        main {
            text-align: center;
            margin-top: 25px;
        }
        #result {
            margin-top: 50px;
        }
        #result p {
            background-color: greenyellow;
            padding: 10px;
            width: 300px;
            margin: 0 auto;
            display: inline-block;
        }
        #transactionTable {
            margin: 0 auto;
        }
        #transactions th {
            text-align: left;
        }
        #transactions td:nth-child(1) {
            width: 200px;
            padding-right: 10px;
        }
        #transactions {
            margin: 0 auto;
            padding: 25px;
            border: 1px solid #222;
        }
    </style>
    <script src="scripts.js"></script>
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
    <audio id="registerSound">
        <source src="register.ogg" type="audio/ogg" hidden>
    </audio>
    <div id="result"></div>
    <table id="transactions">
        <thead>
            <tr>
                <th>Navn</th>
                <th>Verdi</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
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