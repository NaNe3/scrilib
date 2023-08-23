var off = 0;

loc = window.location.href.split("/");
s = loc[loc.length-2];
view(s);
getScribble(s);
getComments(s);

$('#myInput').on("keyup", function(e) {
    if (e.keyCode == 13) {
        window.location = "../../search?q=" + this.value;
    }
});

function getScribble(id) {
    url = "../../php/get.php?typ=sing&id=" + id;
    $.ajax({
         type: 'GET',
         data:$(this).serialize(),
         dataType: 'html',
         url: url,
         success: function (d) {
             data = JSON.parse(d);
             config(data, id);
             getScribbles(data.author, id, data.anon);
             getUser(user, id);
             document.title = data.name + " | Scrilib";
         }
    });
}

function getScribbles(user, id, anon) {
    console.log(user);
//    if (anon == true) {
//        url = "../../php/get.php?typ=scr&sty=Popular&off=0";
//    } else {
//        url = "../../php/get.php?typ=scrAcc&usr=" + user + "&off=0";
//    }
    url = "../../php/get.php?typ=seq&off=" + (parseInt(id)+1);
    $.ajax({
         type: 'GET',
         data:$(this).serialize(),
         dataType: 'html',
         url: url,
         success: function (d) {
             data = JSON.parse(d);
             build(data, id);
         }
    });
}

function getComments(id) {
    url = "../../php/get.php?typ=coms&post=" + id;
    $.ajax({
         type: 'GET',
         data:$(this).serialize(),
         dataType: 'html',
         url: url,
         success: function (d) {
             comments = JSON.parse(d);
             createComments(comments, id);
             document.getElementById("cNum").innerHTML = comments.length + " comments";
         }
    });
}

function getUser(sub, id) {
    url = "../../php/get.php?typ=usrInfo&usr=" + sub;
    $.ajax({
         type: 'GET',
         data:$(this).serialize(),
         dataType: 'html',
         url: url,
         success: function (d) {
             user = JSON.parse(d);
             
             if (auth != false) {
                 if (user[0].saves.indexOf(",e" + id + "e") > -1) {
                     document.getElementById("unsavBtn").style.display = "block";
                 } else {
                     document.getElementById("savBtn").style.display = "block";
                 }
                 
                 if (user[0].upvoted.indexOf(",e" + id  + "e") > -1) {
                     document.getElementById("img1").style.backgroundColor = "orangered";
                 }
                 if (user[0].downvoted.indexOf(",e" + id  + "e") > -1) {
                     document.getElementById("img2").style.backgroundColor = "royalblue";
                 }
             }
         }
    });
}

function createComments(data, id) {
    for (var i=0; i<data.length; i++) {
        com = document.createElement("div");
        com.className = "com";
        com.id = "box" + data[i].id;
        if (data[i].type == "com") {
            com.style = "padding-left: 20px; margin-top: 10px;";
        } else {
            com.style = "margin-bottom: 30px;";
        }
        
        con = document.createElement("div");
        con.className = "comCont";
        
        bar = document.createElement("div");
        bar.className = "comBar";
        usr = document.createElement("a");
        usr.className = "subText";
        usr.innerHTML = "<strong>" + data[i].author + "</strong>";
        usr.href = "../../user/" + data[i].author;
        pnt = document.createElement("p");
        pnt.className = "subText";
        pnt.innerHTML = data[i].points + " pts";
        dat = document.createElement("div");
        dat.className = "subText";
        dat.innerHTML = data[i].date;
        rep = document.createElement("p");
        rep.id = "rep" + data[i].id;
        rep.className = "opt";
        rep.innerHTML = "Reply";
        rep.style = "float: right; margin-top: 8px; color: #666; font-size: 13px;";
        rep.onclick = function() {
            document.getElementById("container" + this.id.substring(3, this.id.length)).style.display = "block";
        }
        
        pst = document.createElement("p");
        pst.style = "margin: 25px 10px;";
        pst.innerHTML = data[i].comment;
        
        bar.appendChild(usr);
        bar.appendChild(pnt);
        bar.appendChild(dat);
        con.appendChild(rep);
        
        con.appendChild(bar);
        con.appendChild(pst);
        com.appendChild(con);
        
        //COMMENT THINGY THING
        mainCon = document.createElement("div");
        mainCon.id = "container" + data[i].id;
        mainCon.style = "margin-top: 10px; padding-left: 20px; display: none;";
        mainCon.className = "com";
        subCon = document.createElement("div");
        subCon.className = "comMent";
        chr = document.createElement("p");
        chr.id = "com" + data[i].id + 'P'
        chr.style = "font-size: 12px; color: #666; position: absolute; bottom: 35px; right: 10px; color: red;";
        chr.innerHTML = "120";
        cls = document.createElement("span");
        cls.innerHTML = "&times;";
        cls.className = "close";
        cls.onclick = function() {
            this.parentElement.parentElement.style.display = "none";
        }
        txa = document.createElement("textarea");
        txa.id = "com" + data[i].id;
        txa.placeholder = "Dont Trip";
        txa.style = "margin-bottom: 40px;";
        txa.oninput = function() {
            AutoGrowTextArea(this);
            ta(this.id, this.id + 'P', this.id + 'B');
        }
        txa.onload = function() {
            ta(this.id, this.id + 'P', this.id + 'B');
        }
        rul = document.createElement("a");
        rul.href = "#";
        rul.style = "float: left; margin: 8px 18px; position: absolute; bottom: 0px; left: 0px;";
        rul.innerHTML = "Refer to the posting guide";
        btn = document.createElement("button");
        btn.id = "com" + data[i].id + 'B';
        btn.className = "b2";
        btn.style = "margin-bottom: 7px; float: right; position: absolute; bottom: 0px; right: 0px;";
        btn.innerHTML = "Post";
        btn.onclick = function() {
            if (auth == true && this.parentElement.childNodes[2].value.length > 0) {
                comment("com", id, this.id.substring(3, this.id.length-1), document.getElementById(this.id.substring(0, this.id.length-1)).value.replace(/'/g, "''").replace(/#/g, ""));
                document.getElementById(this.id.substring(0, this.id.length-1)).value = "";

                this.parentElement.parentElement.style.display = "none";
                ta("mainCom", "mainComP", "mainComB");
                window.location = ".";
            } else {
                alert("sign up, maybe?");
            }
//            com = JSON.parse("{\"id\": 0, \"type\": \"com\", \"no\": " + id + ", \"com\": " + this.id.substring(3, this.id.length-1) + ", \"author\": \"" + user + "\", \"points\": 0, \"comment\": \"" + document.getElementById(this.id.substring(0, this.id.length-1)).value.replace(/'/g, "''") + "\", \"date\": \"May 26\"}");
//            createComments(com);
        }
        subCon.appendChild(chr);
        subCon.appendChild(cls);
        subCon.appendChild(txa);
        subCon.appendChild(rul);
        subCon.appendChild(btn);
        mainCon.appendChild(subCon);
        com.appendChild(mainCon);
        //END OF COMMENT THINGY
        
        if (data[i].type == "pos") {
            document.getElementById("comments").appendChild(com);
        } else {
            coms = document.getElementsByClassName("com");
            for (var j=0; j<coms.length; j++) {
                if (coms[j].id == "box" + data[i].com) {
                    coms[j].appendChild(com);
                }
            }
        }
        
    }
}

function build(data, id) {
    document.getElementById("scribs").style.maxHeight = (window.innerHeight -175) + "px";
    for (var i=0; i<data.length; i++) {
        box = document.createElement("div");
        box.className = "gallBox";
        box.id = data[i].id;
        if (data[i].id == id) { 
//                box.style.border = "1px solid brown";
            box.style.backgroundColor = "white";
            box.style.borderLeft = "3px solid brown";
            box.style.marginLeft = "5px";
        } else {
            box.onclick = function() {
                window.location = "../" + this.id + "/";
            }
        }

        con = document.createElement("div");
        con.className = "imgCont";
        img = document.createElement("img");
        img.src = "../" + data[i].id + "/" + data[i].img;

        con.appendChild(img);
        box.appendChild(con);

        p = document.createElement("p");
        p.innerHTML = data[i].name;
        if (data[i].id == id) { p.style.color = "brown"; }
        box.appendChild(p);
        box.innerHTML += "<p style='width: 150px; float: left;'><img src='../../res/ico/upvote.png' style='width:12px; float: left;'><span style='float: left; margin-left: 7px; margin-top: 0px; font-size: 12px;'>" + data[i].rating + "</span><img src='../../res/ico/views.png' style='width:12px; float: left; margin-top: 0px; margin-left: 50px;'><span style='float: left; margin-left: 7px; margin-top: 0px; font-size: 12px;'>" + data[i].views + "</span></p>";
        document.getElementById("scribs").appendChild(box);
    }
}

function config(data, id) {
    document.getElementById("scrImg").src = data.img;
    
    document.getElementById("next").onclick = function() {
        window.location = "../" + (parseInt(id)+1);
    }
    document.getElementById("back").onclick = function() {
        window.location = "../" + (parseInt(id)-1);
    }
    if (data.anon == true) {
        document.getElementById("scrAuthor").innerHTML = "<span style='color: #00FF7F'>Anonymous</span>";
        document.getElementById("scrAuthor").href = "";
        document.getElementById("authSpot").innerHTML = "";
        document.getElementById("anon").innerHTML = "Spotlight - VIRAL";
    } else {
        document.getElementById("scrAuthor").innerHTML = data.author;
        document.getElementById("scrAuthor").href = "../../user/" + data.author;
        document.getElementById("authSpot").innerHTML = data.author;
        document.getElementById("authSpot").href = "../../user/" + data.author;
    }
    if (auth != false) {
        //document.getElementById("pro").href = "../../user/" + user;
        //document.getElementById("savBtn").style.display = "block";
        proPogate();
        document.getElementById("savBtn").onclick = function () {
            save(id);
            this.style.display = "none";
            document.getElementById("unsavBtn").style.display = "block";
        }
        document.getElementById("unsavBtn").onclick = function () {
            unsave(id);
            this.style.display = "none";
            document.getElementById("savBtn").style.display = "block";
        }
    } 
    document.getElementById("scrTitle").innerHTML = data.name;
    document.getElementById("scrTime").innerHTML = data.date;
    document.getElementById("scrRating").innerHTML = data.rating;
    
    document.getElementById("mainComB").onclick = function() {
        if (auth == true) {
            comment("pos", id, 0, document.getElementById("mainCom").value.replace(/'/g, "''"));
        
            document.getElementById("mainCom").value = "";
            ta("mainCom", "mainComP", "mainComB");
            window.location = "."; 
        } else {
            alert("sign up, maybe?");
        }
    }
    ta("mainCom", "mainComP", "mainComB");
    //document.getElementById("includedContent").style.display = "block";
}

function comment(typ, no, com, val) {
    url = "../../php/comment.php?typ=" + typ + "&no=" + no + "&com=" + com + "&mainCom=" + val;
    $.ajax({
         type: 'GET',
         data:$(this).serialize(),
         dataType: 'html',
         url: url,
        success: function(d) {
            console.log(d);
        }
    });
}

function upvote() {
    if (document.getElementById("img1").style.backgroundColor != "orangered") {
        if (document.getElementById("img1").style.backgroundColor != "orangered" && document.getElementById("img2").style.backgroundColor != "royalblue") {
            document.getElementById("scrRating").innerHTML = parseInt(document.getElementById("scrRating").innerHTML) + 1;
            vote(1);
        } else {
            document.getElementById("scrRating").innerHTML = parseInt(document.getElementById("scrRating").innerHTML) + 2;
            vote(2);
        }
    }
    document.getElementById("img1").style.backgroundColor = "orangered";
    document.getElementById("img2").style.backgroundColor = "#bbb";
}

function downvote() {
    if (document.getElementById("img2").style.backgroundColor != "royalblue") {
        if (document.getElementById("img1").style.backgroundColor != "orangered" && document.getElementById("img2").style.backgroundColor != "royalblue") {
            document.getElementById("scrRating").innerHTML = parseInt(document.getElementById("scrRating").innerHTML) - 1;
            vote(-1);
        } else {
            document.getElementById("scrRating").innerHTML = parseInt(document.getElementById("scrRating").innerHTML) - 2;
            vote(-2);
        }
    }
    document.getElementById("img1").style.backgroundColor = "#bbb";
    document.getElementById("img2").style.backgroundColor = "royalblue";
}

function vote(inc) {
    url = "../../php/change.php?typ=vote&inc=" + inc + "&id=" + s;
    $.ajax({
         type: 'GET',
         data:$(this).serialize(),
         dataType: 'html',
         url: url,
        success: function(d) {
            console.log(d);
        }
    });
}

function view(id) {
    url = "../../php/change.php?typ=view&id=" + id;
    $.ajax({
         type: 'GET',
         data:$(this).serialize(),
         dataType: 'html',
         url: url,
        success: function(d) {
            console.log(d);
        }
    });
}

function save(id) {
    url = "../../php/change.php?typ=sav&id=" + id;
    $.ajax({
        type: 'GET',
        data:$(this).serialize(),
        dataType: 'html',
        url: url,
        success: function(d) {
            console.log(d);
        }
    });
}

function unsave(id) {
    url = "../../php/change.php?typ=unsav&id=" + id;
    $.ajax({
        type: 'GET',
        data:$(this).serialize(),
        dataType: 'html',
        url: url,
        success: function(d) {
            console.log(d);
        }
    });
}

function AutoGrowTextArea(textField) {
    if (textField.clientHeight < textField.scrollHeight) {
    textField.style.height = textField.scrollHeight + "px";
        if (textField.clientHeight < textField.scrollHeight) {
          textField.style.height = (textField.scrollHeight * 2 - textField.clientHeight) + "px";
        }
    } else if (textField.value == "") {
        textField.style.height = "80px";
    }
}