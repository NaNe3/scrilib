exist = false;
userexists = false;
correct = false;
window.onload = function() {
    configure();
}

function configure() {
    if (type == "in") {
        document.getElementById("subBut").onclick = function() {
            validAcc();
        }
    } else {
        document.getElementById("subBut").onclick = function() {
            validate();
        }
        document.getElementById("email").oninput = function() {
            get("email", document.getElementById("email").value);
        }
        document.getElementById("user").oninput = function() {
            labels = document.getElementsByTagName("label");
            get("usr", document.getElementById("user").value);
            setTimeout(function () {
                if (userexists == true) {
                    labels[2].style.display = "block";
                    labels[2].innerHTML = "USERNAME ALREADY EXISTS";
                } else {
                    labels[2].style.display = "none";
                }
            }, 100);
        }
    }
}

function validate() {
    labels = document.getElementsByTagName("label");
    inputs = document.getElementsByClassName("val");
    pro = false;
    if (labels.length > 1) {
        for (var i=0; i<inputs.length; i++) {
            console.log(inputs[i].value.length);
            if (inputs[i].value.length < 3 && inputs[i].id != 
               "email") {
                labels[i].style.display = "block";
                labels[i].innerHTML = "DO NOT LEAVE EMPTY";
                pro = true;
            }
            if (inputs[i].value.length > 50 && inputs[i].id != "email" || inputs[i].id == "email" && inputs[i].value.length > 100) {
                labels[i].style.display = "block";
                labels[i].innerHTML = "TOO LONG!!!";
                pro = true;
            }
            
            if (inputs[i].id == "user") {
                if (userexists == true) {
                    labels[i].style.display = "block";
                    labels[i].innerHTML = "USERNAME ALREADY EXISTS";
                    pro = true;
                }
                
                if (isvalid(inputs[i].value) == false) {
                    labels[i].style.display = "block";
                    labels[i].innerHTML = "CONTAINS INVALID CHARATERS (ALPHANUMERIC ONLY)";
                    pro = true;
                }
            }
            
            if (inputs[i].id == "email" && inputs[i].value.length > 0) {
                if (inputs[i].value.includes('@') == false || inputs[i].value.includes('.') == false) {
                    labels[i].style.display = "block";
                    labels[i].innerHTML = "THIS EMAIL DOESN'T SEEM TO EXIST...";
                    pro = true;
                }
                if (exist == true) {
                    labels[i].style.display = "block";
                    labels[i].innerHTML = "THIS ACCOUNT ALREADY EXISTS";
                    pro = true;
                }   
            }
        }
        if (pro == false) {
            document.getElementById("signup").click();   
        }
        pro = false;
    } else {
        if (correct == true) {
            document.getElementById("signin").click();
        } else {
            labels[0].style.display = "block";
            labels[0].innerHTML = "THE USERNAME OR PASSWORD IS INCORRECT";
        }
    }
}

function isvalid(inputtxt) { 
    var letters = /^[0-9a-zA-Z]+$/;
    if (letters.test(inputtxt)) {
        return true;
    } else {
        return false;
    }
}

function get(mod, subj, res) {
    url = "../../php/get.php?typ=" + mod + "&sub=" + subj;
    $.ajax({
        type: 'GET',
        data:$(this).serialize(),
        dataType: 'html',
        url: url,
        success: function (d) {
            if (mod == "email") {
                if (d == true) {
                    exist = true;
                } else {
                    exist = false;
                }
            } else {
                if (d == true) {
                    userexists = true;
                } else {
                    userexists = false;
                }
            }
        }
    });
}

function validAcc() {
    url = "../../php/get.php?typ=acc&name=" + document.getElementById("user").value + "&pass=" + document.getElementById("pass").value;
    $.ajax({
        type: 'GET',
        data:$(this).serialize(),
        dataType: 'html',
        url: url,
        success: function (d) {
            if (d == "false") {
                correct = false;
            } else {
                correct = true;
            }
            console.log(d);
            validate();
        }
    });
}

