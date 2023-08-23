window.onload = function() {
    $('#myInput').on("keyup", function(e) {
        if (e.keyCode == 13) {
            window.location = "../search?q=" + this.value;
        }
    });
    if (page < 0) {
        page = 1;
    }
    
    if (user != "EL!") {
        proPogate();
    }
    
    config();
    getRows();
}

function config() {
    if (sessionStorage.getItem("Content") == null) {
        sessionStorage.setItem("Content", "scribbles");
    }
    if (sessionStorage.getItem("Display By") == null) {
        sessionStorage.setItem("Display By", "DESC");
    }
    if (sessionStorage.getItem("Time") == null) {
        sessionStorage.setItem("Time", "None");
    }
    if (sessionStorage.getItem("Entry Limit") == null) {
        sessionStorage.setItem("Entry Limit", "25");
    }
    
    conts = document.getElementsByClassName("archive-cat-cont");
    for (var i=0; i<conts.length; i++) {
        opts = conts[i].childNodes;
        for (var j=3; j<opts.length; j+=2) {
            console.log(opts[j].id + " | " + sessionStorage.getItem(opts[1].innerHTML) + " | " + opts[1].innerHTML);
            if (opts[j].id == sessionStorage.getItem(opts[1].innerHTML)) {
                opts[j].style.backgroundColor = "#ddd";
            }
            opts[j].onclick = function() {
                sessionStorage.setItem(this.parentElement.childNodes[1].innerHTML, this.id);
                window.location.reload();
            }
        }
    }
}

function getRows() {
    url = "../php/get.php?typ=archive&sub=" + sessionStorage.getItem("Content") + "&order=" + sessionStorage.getItem("Display By") + "&limit=" + sessionStorage.getItem("Entry Limit") + "&page=" + (page-1);
    $.ajax({
        type: 'GET',
        data:$(this).serialize(),
        dataType: 'html',
        url: url,
        success: function (d) {
            rows = JSON.parse(d);
            console.log(rows);
            if (sessionStorage.getItem("Content") == "scribbles") {
                createScribbles(rows);   
            } else {
                createUsers(rows);
            }
        }
    });
}

function createScribbles(rows) {
    document.getElementById("tbl-styles").style.display = "block";
    for (var i=0; i<rows.length; i++) {
        tr = document.createElement("tr");
        
        style = document.createElement("td");
        style.innerHTML = "<img src='../res/ico/" + rows[i].style + ".png' style='width: 30px; background-color: brown; border-radius: 3px;'>";
        date = document.createElement("td");
        date.innerHTML = rows[i].date;
        date.style = "width: 80px;";
        sname = document.createElement("td");
        sname.innerHTML = rows[i].name;
        sname.style = "color: brown; width: 500px;";
        author = document.createElement("td");
        author.innerHTML = rows[i].author;
        author.style = "color: brown; max-width: 100px; overflow: hidden;";
        rating = document.createElement("td");
        rating.innerHTML = "<img src='../res/ico/upvote.png' style='width:15px; float: left; margin-right: 10px;'>" + rows[i].rating;
        rating.style = "min-width: 50px;";
        views = document.createElement("td");
        views.innerHTML = "<img src='../res/ico/views.png' style='width:15px; float: left; margin-top: 0px; margin-right: 10px;'>" + rows[i].views;
        views.style = "min-width: 50px;";
        
        tr.appendChild(style);
        tr.appendChild(date);
        tr.appendChild(sname);
        tr.appendChild(author);
        tr.appendChild(rating);
        tr.appendChild(views);
        
        document.getElementById("tbl-styles").appendChild(tr);
    }
}

function createUsers(rows) {
    document.getElementById("tbl-users").style.display = "block";
    for (var i=0; i<rows.length; i++) {
        tr = document.createElement("tr");
        
        pic = document.createElement("td");
        pic.innerHTML = "<img src='../res/usr/" + rows[i].img + "' style='width: 30px; background-color: white; border-radius: 3px; border: 1px solid brown;'>";
        uname = document.createElement("td");
        uname.innerHTML = rows[i].name;
        uname.style = "width: 500px;";
        scrNum = document.createElement("td");
        scrNum.innerHTML = "<img src='../res/ico/scr.png' style='width:15px; float: left; margin-right: 10px; background-color: brown; border-radius: 3px;'>" + rows[i].scribbles + " Scribbles";
        scrNum.style = "width: 80px;";
        fol = document.createElement("td");
        fol.innerHTML = "<img src='../res/ico/acc.png' style='width:15px; float: left; margin-right: 10px; background-color: brown; border-radius: 3px;'>" + (rows[i].followers.split(",").length-1) + " Followers";
        fol.style = "width: 80px;";
        fng = document.createElement("td");
        fng.innerHTML = "<img src='../res/ico/acc.png' style='width:15px; float: left; margin-right: 10px; background-color: brown; border-radius: 3px;'>" + (rows[i].followers.split(",").length-1) + " Following";
        fng.style = "width: 80px;";
        
        tr.appendChild(pic);
        tr.appendChild(uname);
        tr.appendChild(scrNum);
        tr.appendChild(fol);
        tr.appendChild(fng);
        
        document.getElementById("tbl-users").appendChild(tr);
    }
}













