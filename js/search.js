off = 0;
aff = 0;
ini = 0;
c = [0,0,0];
comOff = 0;


window.onload = function() {
    document.getElementById("name").innerHTML = "Text";
    configure();
    
    if (sessionStorage.getItem("Search For") == "scribbles" || sessionStorage.getItem("Search For") == null) {
        searchScribbles(query);
    } else if (sessionStorage.getItem("Search For") == "users") {
        searchUsers(query);
    } else {
        searchComments(query);
    }
}

function searchUsers(query) {
    url = "../php/search.php?typ=users&q=" + query;
    $.ajax({
         type: 'GET',
         data:$(this).serialize(),
         dataType: 'html',
         url: url,
         success: function (d) {
             users = JSON.parse(d);
             console.log("users: " + users.length);
             if (users.length > 0) {
                build(users, aff);   
             } else if (aff == 0) {
                 aff = -1;
                 document.getElementById("feed").innerHTML += "<h1 style='text-align: center; color: brown;  margin-top: 50px;'>No Artists Found</h1>";
             }
         }
    });
}

function searchComments(query) {
    order = sessionStorage.getItem("Order By");
    display = sessionStorage.getItem("Displays");
    search = sessionStorage.getItem("Search By");
    url = "../php/search.php?typ=comments&q=" + query + "&order=" + order + "&display=" + display + "&search=" + search + "&off=" + comOff;
    $.ajax({
        type: 'GET',
        data:$(this).serialize(),
        dataType: 'html',
        url: url,
        success: function (d) {
            comments = JSON.parse(d);
            console.log(comments);
            if (comments.length > 0) {
                createComments(comments);
            } else if (comOff == 0) {
                comOff = -1;
                document.getElementById("feed").innerHTML += "<h1 style='text-align: center; color: brown; margin-top: 50px;'>No Comments Found</h1>";
            }
        }
    });
}

function searchScribbles(query) {
    order = sessionStorage.getItem("Order By");
    display = sessionStorage.getItem("Displays");
    search = sessionStorage.getItem("Search By");
    url = "../php/search.php?typ=scribbles&q=" + query + "&order=" + order + "&display=" + display + "&search=" + search + "&off=" + off;
    $.ajax({
        type: 'GET',
        data:$(this).serialize(),
        dataType: 'html',
        url: url,
        success: function (d) {
            data = JSON.parse(d);
            console.log("scribbles: " + data.length);
            if (data.length > 0) {
                createImages(data);
                document.getElementById("cas").style.display = "block";
            } else if (off == 0) {
                off = -1;
                document.getElementById("feed").innerHTML += "<h1 style='text-align: center; color: brown;  margin-top: 50px;'>No Scribbles Found</h1>";
            }
        }
    });
}

$('#myInput').on("keyup", function(e) {
    if (e.keyCode == 13) {
        window.location = "../search/?q=" + this.value;
    }
});

function configure() {
    if (sessionStorage.getItem("Search For") == null) {
        sessionStorage.setItem("Search For", "scribbles");
    }
    if (sessionStorage.getItem("Search By") == null) {
        sessionStorage.setItem("Search By", "*");
    }
    if (sessionStorage.getItem("Order By") == null) {
        sessionStorage.setItem("Order By", "id");
    }
    if (sessionStorage.getItem("Displays") == null) {
        sessionStorage.setItem("Displays", "ASC");
    }
    
    if (sessionStorage.getItem("Search For") == "users") {
        cats = document.getElementsByClassName("search-cat-cont");
        cats[1].style.display = "none";
        cats[2].style.display = "none";
    }
    
    if (user != "EL!") {
        proPogate();
    }
    
    nodes = document.getElementsByClassName("search-opt");
    for (var i=0; i<nodes.length; i++) {
        if (nodes[i].id == sessionStorage.getItem("Search For") || nodes[i].id == sessionStorage.getItem("Search By") || nodes[i].id == sessionStorage.getItem("Order By") || nodes[i].id == sessionStorage.getItem("Displays")) {
            nodes[i].style.backgroundColor = "#ddd";
            
            typ = nodes[i].parentElement.childNodes[1].innerHTML;
            if (nodes[i].parentElement.style.display != "none") {
                document.getElementById("tag-container").innerHTML += "<p class='tag'><strong>" + typ + " \"<span style='border-bottom: 2px solid brown;'>" + nodes[i].innerHTML + "</span>\"</strong></p>";   
            }
        }
        
        nodes[i].onclick = function() {
//            if (this.style.backgroundColor != "#ddd") {
//                opts = this.parentElement.childNodes;
//                console.log(opts);
//                for (var j=1; j<opts.length; j+=2) {
//                    opts[j].style.backgroundColor = "#fbfbfb";
//                }
//                this.style.backgroundColor = "#ddd";
//            }
            sessionStorage.setItem(this.parentElement.childNodes[1].innerHTML, this.id);
            window.location.reload();
        }
    }
}

function createImages(data) {
//    document.getElementById("imgRow").style.display = "block";
    for (var i=0; i<data.length; i++) {
        box = document.createElement("div");
        box.id = data[i].id;
        box.onclick = function() {
            window.location = "../scribble/" + this.id + "/";
        }
        box.className = "container";
        box.style = "overflow: hidden; visibility: hidden;";
        
        img = document.createElement("img");
        img.className = "image";
        img.onload = function() {
            this.parentElement.style.visibility = "visible";
        }
        img.src = "../scribble/" + data[i].id + "/" + data[i].img;
        box.appendChild(img);
        
        mid = document.createElement("mid");
        mid.className = "middle";
        
        mid.innerHTML = "<strong>" + data[i].name + "</strong> by ";
        if (data[i].anon == 1) {
            mid.innerHTML += "<span style='color: #00FF7F'>anon</span>"; 
        } else {
            mid.innerHTML += "<span style='color: brown'>" + data[i].author + "</span>"; 
        }
        mid.innerHTML += "<br><br><p><img src='../res/ico/upvote.png' style='width:15px; float: left;'><span style='float: left; margin-left: 10px; margin-top: 0px;'>" + data[i].rating + "</span><span style='float: right; margin-left: 10px; margin-top: 0px;'>" + data[i].views + "</span><img src='../res/ico/views.png' style='width:15px; float: right; margin-top: 0px'></p>";
        
        box.appendChild(mid);
        
        for (var j=0; j<3; j++) {
            var points = 0;
            for (var k=0; k<3; k++) {
                if (c[j] <= c[k]) {
                    points += 1;
                }
            }
            //console.log(points);
            if (points == 3) {
                document.getElementById("c" + (j+1)).appendChild(box);
                c[j] += parseInt(getHeight(data, i));
                break;
            }
        }
    }
    if (data.length > 0) {
         //off = ini - data[data.length-1].id+1;
        off += 20;
    }
}

function createComments(data) {
    for (var i=0; i<data.length; i++) {
        oc = true;
        por = document.getElementsByClassName("portCom");
        for (var j=0; j<por.length; j++) {
            if (por[j].id == "port"+data[i].no) {
                oc = false;
                parentId = por[j].id;
            }
        }
        
        if (oc == true) {
            box = document.createElement("div");
            box.className = "portCom";
            box.id = "port" + data[i].no;
            box.onclick = function() {
                window.location = "../scribble/" + this.id.substring(4, this.id.length);
            }

            dIv = document.createElement("div");
            dIv.className = "portImg";
            img = document.createElement("img");
            getThumb(data[i].no, img);
            dIv.appendChild(img);
        }
        
        topBar = document.createElement("div");
        topBar.className = "comBar";
        topBar.innerHTML = '<a href="../user/' + data[i].author + '" class="subText"><strong>' + data[i].author + '</strong></a><p class="subText">' + data[i].points + ' pts</p><p class="subText">' + data[i].date + '</p>';
        
        com = document.createElement("p");
        com.innerHTML = data[i].comment;
        com.style += "float: left; margin-left: 130px;";
        
        if (oc == true) {
            box.appendChild(dIv);
            box.appendChild(topBar);
            box.appendChild(com);
            document.getElementById("feed").appendChild(box);
        } else {
            document.getElementById(parentId).appendChild(topBar);
            document.getElementById(parentId).appendChild(com);
        }
    }
    
    comOff += 30;
}

function getThumb(id, elem) {
    url = "../php/get.php?typ=sing&id=" + id;
    $.ajax({
         type: 'GET',
         data:$(this).serialize(),
         dataType: 'html',
         url: url,
         success: function (d) {
             data = JSON.parse(d);
             elem.src = "../scribble/" + data['id'] + "/" + data['img'];
         }
    });
}

function build(data, off) {
    //console.log(data);
    for (var i=off; i<off+data.length; i++) {
        box = document.createElement("div");
        box.style = "height: 120px; width: 175px; border: 1px solid #bbb; border-radius: 3px; float: left; margin: 10px; background-color: #fff; overflow: hidden; text-align: center;";
        box.className = "hover";

        clr = document.createElement("div");
        clr.style = "width: 100%; height: 40px; background-color: brown;";
        box.appendChild(clr);

        evr = document.createElement("div");
        evr.style = "width: 100%; height: 90px; margin-top: -20px;";
        proImg = document.createElement("img");
        proImg.src = "../res/usr/" + data[i].img;
        proImg.style = "width: 45px; height: 45px; float: left; border: 1px solid brown; border-radius: 3px; margin: 7px; background-color: white;";
        evr.appendChild(proImg);

        nme = document.createElement("p");
        nme.style = "margin-top: 23px; color: brown; margin-bottom: 0px; cursor: pointer; float: left; max-width: 110px;";
        nme.innerHTML = data[i].name;
        nme.onmouseover = function() { this.style.textDecoration = "underline"; }
        nme.onmouseout = function() { this.style.textDecoration = "none"; }
        nme.onclick = function() {
            sessionStorage.removeItem("settings");
            window.location = "../user/" + this.innerHTML + "/";
        }
        evr.appendChild(nme);

        span = document.createElement("span");
        span.style = "color: #999; line-height: 10px; font-size: 12px; float: left; width: 110px; text-align: left;";
        span.innerHTML = "Scribbles: " + data[i].scribbles;
        fng = document.createElement("button");
        fng.style = "margin-top: 5px; display: none; width: 160px; margin-left: 7px;";
        fng.className = "b2";
        fng.innerHTML = "Following";
        fng.onmouseover = function() {
            this.innerHTML = "Unfollow";
            this.style.backgroundColor = "brown";
            this.style.color = "white";
        }
        fng.onclick = function() {
            unfollow(this.parentElement.childNodes[1].innerHTML);
            this.parentElement.childNodes[4].style.display = "block";
            this.style.display = "none";
        }
        fng.onmouseout = function() {
            this.innerHTML = "Following";
            this.style.backgroundColor = "white";
            this.style.color = "brown";
        }
        fol = document.createElement("button");
        fol.style = "margin-top: 5px; display: none; width: 160px;";
        fol.className = "b1";
        fol.innerHTML = "Follow";
        fol.onclick = function() {
            follow(this.parentElement.childNodes[1].innerHTML);
            this.parentElement.childNodes[3].style.display = "block";
            this.style.display = "none";
        }
        if (data[i].followers.indexOf(user) > -1) {
            fng.style.display = "block";
        } else {
            fol.style.display = "block";
        }
        
        evr.appendChild(span);
        evr.appendChild(fng);
        evr.appendChild(fol);
        box.appendChild(evr);
        document.getElementById("feed").appendChild(box);
    }
    aff += data.length;
}

function follow(user) {
    url = "../php/change.php?typ=fol&per=" + user;
    $.ajax({
         type: 'GET',
         data:$(this).serialize(),
         dataType: 'html',
         url: url,
         success: function (d) {
             console.log(d);
         }
    });
}

function unfollow(user) {
    url = "../php/change.php?typ=unfol&per=" + user;
    $.ajax({
         type: 'GET',
         data:$(this).serialize(),
         dataType: 'html',
         url: url,
         success: function (d) {
             console.log(d);
         }
    });
}

$(window).scroll(function() {
    if($(window).scrollTop() + $(window).height() >= $(document).height()) {
        if (sessionStorage.getItem("Search For") == "scribbles") {
            searchScribbles(query);   
        } else if (sessionStorage.getItem("Search For") == "users") {
            searchUsers(query);
        } else {
            searchComments(query);
        }
    }
});

function getHeight(data, i) {
    var height = (data[i].height * 100)/data[i].width;
    return height;
}