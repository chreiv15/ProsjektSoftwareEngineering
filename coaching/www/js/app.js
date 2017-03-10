// Ionic Starter App

// angular.module is a global place for creating, registering and retrieving Angular modules
// 'starter' is the name of this angular module example (also set in a <body> attribute in index.html)
// the 2nd parameter is an array of 'requires'
angular.module('starter', ['ionic'])

.run(function ($ionicPlatform) {
    $ionicPlatform.ready(function () {
        if (window.cordova && window.cordova.plugins.Keyboard) {
            // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
            // for form inputs)
            cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);

            // Don't remove this line unless you know what you are doing. It stops the viewport
            // from snapping when text inputs are focused. Ionic handles this internally for
            // a much nicer keyboard experience.
            cordova.plugins.Keyboard.disableScroll(true);
        }
        if (window.StatusBar) {
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
    };
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }

    x[pageIndex - 1].style.display = "block";
}

function getLocalStorage(name) {
    var data = localStorage.getItem(name);
    data = JSON.parse(data);
    console.log(data);
    return data;
}

function readLogin() {
    console.log('Reading login...');
    login = getLocalStorage("login");
    login['id'] = parseInt(login['id']);
    login['goalId'] = parseInt(login['goalId']);
    login['goalValue'] = parseFloat(login['goalValue']);
    login['beforeSpending'] = parseFloat(login['beforeSpending']);
    login['accountValue'] = parseFloat(login['accountValue']);
    login['accountId'] = parseInt(login['accountId']);
    login['sprintId'] = parseInt(login['sprintId']);
    window.login = login;
    $('#user-name').html(login.firstname + ' ' + login.lastname);
}
readLogin();