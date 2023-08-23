function tripto(loc) {
    window.location = loc;
}

function prepareImg() {
    var canvas = document.getElementById('canvas');
    document.getElementById('inp_img').value = canvas.toDataURL();
    document.getElementById("name").value = document.getElementById("scrName").value;
    document.getElementById("genre").value = document.getElementById("scrGenre").value;
    document.getElementById("height").value = document.getElementById("cHeight").value;
    document.getElementById("width").value = document.getElementById("cWidth").value;
    
    validateCanv();
    if (publish == true) {
        document.getElementById("bt_upload").click();   
    }
}

function ta(text, char, but) {
    console.log(char);
    val = document.getElementById(text).value.length;
    chr = document.getElementById(char);
    
    chr.innerHTML = 120 - parseInt(val);
    if (120 - parseInt(val) < 0 || val == 0) {
        chr.style.color = "red";
        document.getElementById(but).disabled = true;
        document.getElementById(but).style.cursor = "not-allowed";
    } else {
        chr.style.color = "#666";
        document.getElementById(but).disabled = false;
        document.getElementById(but).style.cursor = "pointer";
    }
}

function logOut(url) {
    $.ajax({
         type: 'GET',
         data:$(this).serialize(),
         dataType: 'html',
         url: url,
         success: function (d) {//begin success
            window.location = "./";
         }
    });
}

function proPogate() {
    img = document.getElementById("pro-btn");
    drp = document.getElementById("pro-drop");

    window.onclick = function(event) {
        if (event.target.id != "pro-btn" && event.target.id != "pro-drop") {
            $("#pro-drop").animate({opacity: '0'}, "fast");
            document.getElementById("pro-drop").style.display = "none";
            document.getElementById("tri-cont").style.display = "none";
            $("#tri-cont").animate({opacity: '0'}, "fast");
        }
    }

    img.onclick = function() {
        if (drp.style.opacity == 0) {
            $("#pro-drop").animate({opacity: '1'}, "fast");
            document.getElementById("pro-drop").style.display = "block";
            document.getElementById("tri-cont").style.display = "block";
            $("#tri-cont").animate({opacity: '1'}, "fast");
        }
    }
}