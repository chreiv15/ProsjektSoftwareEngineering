// Ionic Starter App

// angular.module is a global place for creating, registering and retrieving Angular modules
// 'starter' is the name of this angular module example (also set in a <body> attribute in index.html)
// the 2nd parameter is an array of 'requires'
angular.module('starter', ['ionic'])

.run(function($ionicPlatform) {
  $ionicPlatform.ready(function() {
    if(window.cordova && window.cordova.plugins.Keyboard) {
      // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
      // for form inputs)
      cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);

      // Don't remove this line unless you know what you are doing. It stops the viewport
      // from snapping when text inputs are focused. Ionic handles this internally for
      // a much nicer keyboard experience.
      cordova.plugins.Keyboard.disableScroll(true);
    }
    if(window.StatusBar) {
      StatusBar.styleDefault();
    }
  });
})

var pageIndex = 2;
showPage(pageIndex);

function plusPage(n) {
    showPage(pageIndex = n);
}

function showPage(n) {
    var i;
    var x = document.getElementsByClassName("page");
    if (n > x.length) {
        pageIndex = 1
    } 
    if (n < 1) {
        pageIndex = x.length
    } ;
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none"; 
    }
    
    x[pageIndex-1].style.display = "block"; 
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











