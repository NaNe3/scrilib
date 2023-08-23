window.onload = function() {
    $('#myInput').on("keyup", function(e) {
        if (e.keyCode == 13) {
            window.location = "../search?q=" + this.value;
        }
    });
    
    if (sessionStorage.getItem("pg-set") == null) {
        sessionStorage.setItem("pg-set", "General")
    }
    
    proPogate();
    getUsr(user);
    tabConfig();
}

function getUsr(user) {
    console.log(user);
    url = "../php/get.php?typ=usrInfo&usr=" + user;
    $.ajax({
        type: 'GET',
        data:$(this).serialize(),
        dataType: 'html',
        url: url,
        success: function (d) {
            user = JSON.parse(d);
            //config(user);
        }
    });
}

function tabConfig() {
    tabs = document.getElementsByClassName("style");
    for (var i=0; i<tabs.length; i++) {
        console.log(tabs[i].childNodes[3].innerHTML + " ||| " + sessionStorage.getItem("pg-set"));
        if (tabs[i].childNodes[3].innerHTML == sessionStorage.getItem("pg-set")) {
            tabs[i].style.backgroundColor = "#ddd";
            tabs[i].childNodes[1].childNodes[1].style.backgroundColor = "brown";
        }
    }
}