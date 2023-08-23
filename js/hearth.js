art = ["scribbleWars.png", "ohsheep.png", "cboy.png", "butter.png"];

var off = 0;
style = "";
ini = 0;
feedOff("scribbles");
//getCol();
var c = [0,0,0];

function search(el) {
    if (this.event.keyCode == 13) {
        window.location = "./search?q=" + el.value;
    }
}

window.onload = function() {
    if (sessionStorage.getItem("style") == undefined) {
        sessionStorage.setItem("style", "*");
    }
        
//    if (sessionStorage.getItem("style") == "*") {
//        document.getElementById("style-tag").innerHTML = '<strong>Scribble Category: \"<span style="border-bottom: 2px solid brown;\">New</span>"</strong>';
//    } else {
//        document.getElementById("style-tag").innerHTML = '<strong>Scribble Category: \"<span style="border-bottom: 2px solid brown;\">' + sessionStorage.getItem("style") + '</span>"</strong>';
//    }
    
    //console.log(sessionStorage.getItem("style"));
    style = sessionStorage.getItem("style");
    try {
        proPogate();
        console.log(user);
    } catch(e) {
        user = "El!";
    }
    getUser(user);
    getStyles();
}

function getUser(usr) {
    console.log(usr);
    url = "./php/get.php?typ=usrInfo&usr=" + usr;
    $.ajax({
         type: 'GET',
         data:$(this).serialize(),
         dataType: 'html',
         url: url,
         success: function (d) {
             user = JSON.parse(d);
             if (style == "Feed" && usr != "null" || style != "Feed") {
                getScribbles(sessionStorage.getItem("style"), user);
             } else {
                 document.getElementById("feed").innerHTML += '<br><h1 style="color: brown; text-align: center;">To Customize your Feed</h1><div style="width: 550px; margin: auto;"><button class="b1" style="margin-top: 11px; margin-left: 180px;" onclick="window.location=\'./p/signin/\'">Log In</button> or <button class="b2" style="margin-top: 11px;" onclick = "window.location=\'./p/signup/\'">Sign Up</button></div>'; 
             }
             
             if (style == "Feed") {
                 if (usr != "null") {
                    getHot(user);   
                 }
                 if (user[0].following.split(",").pop(0).length== 0) {
                     document.getElementById("feed").innerHTML +=  "<img src='./res/ast/" + art[Math.floor(Math.random() * art.length)] + "'>";
                 }
             } else {
                 //document.getElementById("post-head-cont").style.display = "none";
             }
         }
    });
}

function getHot(usr) {
    url = "./php/get.php?typ=hotCom";
    $.ajax({
         type: 'GET',
         data:$(this).serialize(),
         dataType: 'html',
         url: url,
         success: function (d) {
            data = JSON.parse(d);
             if (data.length > 0) {
                 document.getElementById("follow").style.display = 'block';
                 build(data, usr);
             }
         }
    });
}

function showUsers() {
    console.log("follow some peeps");
}

function getScribbles(style, user) {
    console.log(style);
    if (style == "Feed" && user != "null") {
        url = "php/get.php?typ=scr&off=" + off + "&sty=" + style + "&usr=" + user[0].following;
    } else if (style != "Feed") {
        url = "php/get.php?typ=scr&off=" + off + "&sty=" + style;
    }
    $.ajax({
         type: 'GET',
         data:$(this).serialize(),
         dataType: 'html',
         url: url,
         success: function (d) {
            data = JSON.parse(d);
             if (off == 0) {
                 showUsers();
             }
            createImages(data); 
         }
    });
}

function getCol() {
    url = "php/get.php?typ=clr&usr=" + user;
    $.ajax({
         type: 'GET',
         data:$(this).serialize(),
         dataType: 'html',
         url: url,
         success: function (d) {
             var apppp = angular.module("myApp", []);
            apppp.controller("web-cont", function($scope) {
                $scope.color = "green";
            });
         }
    });
}

function getStyles() {
    url = "php/get.php?typ=sty";
    $.ajax({
         type: 'GET',
         data:$(this).serialize(),
         dataType: 'html',
         url: url,
         success: function (d) {
             console.log(off);
             styles = JSON.parse(d);
             createStyles(styles);
         }
    });
}

function createImages(data) {
//    document.getElementById("imgRow").style.display = "block";
    for (var i=0; i<data.length; i++) {
        box = document.createElement("div");
        box.id = data[i].id;
        box.onclick = function() {
            window.location = "./scribble/" + this.id + "/";
        }
        box.className = "container";
        box.style = "overflow: hidden; visibility: hidden;";
        
        img = document.createElement("img");
        img.className = "image";
        img.onload = function() {
            this.parentElement.style.visibility = "visible";
        }
        img.src = "./scribble/" + data[i].id + "/" + data[i].img;
        
//        divi = document.createElement("div");
//        divi.style = "width: 100%; background-color: #ddd; margin-bottom: 12px; border-radius: 0px 0px 3px 3px; padding: 10px 0px 10px 10px;";
//        divi.innerHTML = "qweqeqweqwe";
        
        box.appendChild(img);
//        box.appendChild(divi);
        
        mid = document.createElement("mid");
        mid.className = "middle";
        
        mid.innerHTML = "<strong>" + data[i].name + "</strong> by ";
        if (data[i].anon == 1) {
            mid.innerHTML += "<span style='color: #00FF7F'>anon</span>"; 
        } else {
            mid.innerHTML += "<span style='color: brown'>" + data[i].author + "</span>"; 
        }
        mid.innerHTML += "<br><br><p><img src='./res/ico/upvote.png' style='width:15px; float: left;'><span style='float: left; margin-left: 10px; margin-top: 0px;'>" + data[i].rating + "</span><span style='float: right; margin-left: 10px; margin-top: 0px;'>" + data[i].views + "</span><img src='./res/ico/views.png' style='width:15px; float: right; margin-top: 0px'></p>";
        
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
        if (style == "Feed") {
            off = ini - data[data.length-1].id+1;
        } else {
            off += data.length;
        }
    }
}

function feedOff(db) {
    url = "php/get.php?typ=pstNum&base=" + db;
    $.ajax({
         type: 'GET',
         data:$(this).serialize(),
         dataType: 'html',
         url: url,
         success: function (d) {
             console.log(d);
             ini = d;
         }
    });
}

function getHeight(data, i) {
    var height = (data[i].height * 100)/data[i].width;
    return height;
}

function createStyles(styles) {
    for (var i=0; i<styles.length; i++) {
        if (styles[i].style == sessionStorage.getItem("style") || styles[i].style == "New" &&sessionStorage.getItem("style") == "*") {
            document.getElementById("styImg").src = styles[i].src; document.getElementById("styName").style.backgroundColor = "#fff";
            document.getElementById("styName").innerHTML = styles[i].style + " | Scribbles"; document.getElementById("styDes").style.backgroundColor = "#fff";
            //document.getElementById("styDes").innerHTML = styles[i].des; 
            document.getElementById("styPosts").style.backgroundColor = "#fff";
            document.getElementById("styPosts").innerHTML = styles[i].scribbles + " Scribbles";
            document.getElementById("styBtn").onclick = function () {
                window.location = "./p/canvas/";
            }
            
            document.getElementById("topImg").src = styles[i].src;
            document.getElementById("topName").innerHTML = styles[i].style + " | Scribbles";
            document.getElementById("topNum").innerHTML = styles[i].scribbles + " Scribbles";
            document.getElementById("styBtn1").onclick = function () {
                window.location = "./p/canvas/";
            }
        }
//        if (sessionStorage.getItem("style") == "*") {
//            document.getElementById("filter").style.display = "none";
//        }
        
        box = document.createElement("div");
        box.className = "style";
        if (i == 0) {
            box.style.backgroundColor = "#ddd";
            console.log(user);
            if (user == "null" || user.length == 0) {
                box.style.display = "none";
            }
        }
        box.id = styles[i].style;
        box.onclick = function() {
            style = this.childNodes[1].innerHTML;
            genStyle(this.childNodes[1].innerHTML);
        }
        
        subBox = document.createElement("div");
        subBox.className = "imgDiv";
        if (i == 0) {
            subBox.style.backgroundColor = "brown";
        }
        
        img = document.createElement("img");
        img.src = styles[i].src;
        subBox.appendChild(img);
        
        p = document.createElement("p");
        p.innerHTML = styles[i].style;
        
        box.appendChild(subBox);
        box.appendChild(p);
        if (i > 9) {
            document.getElementById("otherStys").appendChild(box);
        } else {
            document.getElementById("styles").appendChild(box);
        }
        
        if (i == 2) {
            hr = document.createElement("hr");
            document.getElementById("styles").appendChild(hr);
        }
    }
    
    style = sessionStorage.getItem("style");
    if (style == "*") {
        style = "New";
    }
    divs = document.getElementsByClassName("style");
    for (var j=0; j<divs.length; j++) {
        divs[j].style.backgroundColor = "#fafafa";
        divs[j].childNodes[0].style.backgroundColor = "#aaa";
    }
    div = document.getElementById(style);
    div.style.backgroundColor = "#ddd";
    div.childNodes[0].style.backgroundColor = "brown";
}

function genStyle(style) {
//    imgs = document.getElementsByClassName("postImg");
//    while (imgs.length != 0) {
//        for (var j=0; j<imgs.length; j++) {
//            imgs[0].parentNode.removeChild(imgs[0]);
//        }   
//    }
    sessionStorage.setItem("style", style);
    if (style == "New") {
        sessionStorage.setItem("style", "*");
    }
    location.reload();
}

$(window).scroll(function() {
    //console.log(($(window).scrollTop() + $(window).height()) + "       " + $(document).height());
    if($(window).scrollTop() + $(window).height() >= $(document).height()) { 
        getScribbles(sessionStorage.getItem("style"), user);
    }
    
    if ($(window).scrollTop() > 170) {
        document.getElementById("stickyBoi").style.display = "block";
    } else {
        document.getElementById("stickyBoi").style.display = "none";
    }
});

function build(data, user) {
    console.log(data);
    for (var i=0; i<data.length; i++) {
        box = document.createElement("div");
        box.style = "height: 85px; width: 125px; border: 1px solid #bbb; border-radius: 3px; float: left; margin: 10px; background-color: #fff; overflow: hidden; text-align: center; display: inline; box-shadow: 1px 1px 3px 3px rgba(200, 200, 200, .2)";
        box.className = "hover";
        
        nme = document.createElement("p");
        nme.style = "margin-top: 10px; color: brown; margin-bottom: -5px; cursor: pointer;";
        nme.innerHTML = data[i].name;
        nme.onmouseover = function() { this.style.textDecoration = "underline"; }
        nme.onmouseout = function() { this.style.textDecoration = "none"; }
        nme.onclick = function() {
            sessionStorage.removeItem("settings");
            window.location = "./user/" + this.innerHTML + "/";
        }
        box.appendChild(nme);

        span = document.createElement("span");
        span.style = "color: #999; line-height: 0px; font-size: 12px; margin-bottom: 0px; margin-top: -10px;";
        span.innerHTML = "Scribbles: " + data[i].scribbles;
        fng = document.createElement("button");
        fng.style = "margin-top: 5px; display: none; width: 110px; float: left; margin-left: 7px;";
        fng.className = "b2";
        fng.innerHTML = "Following";
        fng.onmouseover = function() {
            this.innerHTML = "Unfollow";
            this.style.backgroundColor = "brown";
            this.style.color = "white";
        }
        fng.onclick = function() {
            unfollow(this.parentElement.childNodes[0].innerHTML);
            this.parentElement.childNodes[3].style.display = "block";
            this.style.display = "none";
        }
        fng.onmouseout = function() {
            this.innerHTML = "Following";
            this.style.backgroundColor = "white";
            this.style.color = "brown";
        }
        fol = document.createElement("button");
        fol.style = "margin-top: 5px; display: none; width: 110px;";
        fol.className = "b1";
        fol.innerHTML = "Follow";
        fol.onclick = function() {
            follow(this.parentElement.childNodes[0].innerHTML);
            this.parentElement.childNodes[2].style.display = "block";
            this.style.display = "none";
        }

        if (user[0].following.indexOf(data[off+i]) > -1) {
            fng.style.display = "block";
        } else {
            fol.style.display = "block";
        }
        box.appendChild(span);
        box.appendChild(fng);
        box.appendChild(fol);
        document.getElementById("minCont").appendChild(box);
    }
}

function getAttr(attr, user, elem) {
    url = "../../php/get.php?typ=usrAttr&attr=" + attr + "&usr=" + user;
    $.ajax({
         type: 'GET',
         data:$(this).serialize(),
         dataType: 'html',
         url: url,
         success: function (d) {
             console.log(d);
             elem.innerHTML = "Scribbles: " + d;
         }
    });
}

function follow(user) {
    url = "./php/change.php?typ=fol&per=" + user;
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
    url = "./php/change.php?typ=unfol&per=" + user;
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