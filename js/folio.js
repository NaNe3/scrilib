var off = 0;
var folOff = 0;
var fngOff = 0;
var comOff = 0;
var savOff = 1;
var upsOff = 1;
var downsOff = 1;
style = "";
scribbles = true;
var c = [0,0,0];
var h = [0,0,0];
var u = [0,0,0];
var d = [0,0,0];
feedOff("comments");

loc = window.location.href.split("/");
s = loc[loc.length-2];
document.title = s + " | Scrilib";
if (sessionStorage.getItem("settings") == undefined) {
    sessionStorage.setItem("settings", "cols");
}
//getScribbles(sessionStorage.getItem("style"), user);
getAttr("scribbles", s, document.getElementById("usrPosts"));
getUsr(s);

function getScribbles(style, name) {
    console.log(style);
    url = "../../php/get.php?typ=scrAcc&off=" + off + "&usr=" + name;
    $.ajax({
         type: 'GET',
         data:$(this).serialize(),
         dataType: 'html',
         url: url,
         success: function (d) {
            data = JSON.parse(d);
             if (data.length > 0) {
                createImages(data, 1);
             } else if (off == 0) {
                 scribbles = false;
                 document.getElementById("colsD").innerHTML += "<h1 style='color: brown; text-align: center; margin-top: 100px;'>No Scribbles</h1>";
             }
         }
    });
}

function getCom(name) {
    url = "../../php/get.php?typ=usrCom&off=" + comOff + "&usr=" + name;
    $.ajax({
        type: 'GET',
        data:$(this).serialize(),
        dataType: 'html',
        url: url,
        success: function (d) {
            data = JSON.parse(d);
            console.log(data);
            if (data.length > 0) {
                createComments(data);
            } else if (comOff == 0) {
                document.getElementById("comD").innerHTML += "<h1 style='color: brown; text-align: center; margin-top: 100px;'>No Comments</h1>";
                comOff = -1;
            }
        }
    });
}

function getUsr(usr) {
    console.log(usr);
    url = "../../php/get.php?typ=usrInfo&usr=" + usr;
    $.ajax({
         type: 'GET',
         data:$(this).serialize(),
         dataType: 'html',
         url: url,
         success: function (d) {
             user = JSON.parse(d);
             console.log(user);
             config(user);
             
             switchTo(sessionStorage.getItem("settings"));
         }
    });
}

function followers(user) {
    list = user[0].followers.split(",");
    console.log(list);
    
    build(list, folOff, document.getElementById("folD"), "fol", user);
    folOff += 40;
}

function following(user) {
    list = user[0].following.split(",");
    console.log(list);
    
    build(list, fngOff, document.getElementById("fngD"), "fng", user);
    fngOff += 40;
}

function build(data, off, elem, typ, user) {
    //console.log(data);
    data.reverse();
    console.log(data);
    for (var i=0; i<40; i++) {
        if (data[off+i] != undefined && data[off+i] != "") {
            box = document.createElement("div");
            box.style = "height: 120px; width: 175px; border: 1px solid #bbb; border-radius: 3px; float: left; margin: 10px; background-color: #fff; overflow: hidden; text-align: center; opacity: 0;";
            box.className = "hover";
            
            clr = document.createElement("div");
            clr.style = "width: 100%; height: 40px; background-color: brown;";
            box.appendChild(clr);
            
            evr = document.createElement("div");
            evr.style = "width: 100%; height: 90px; margin-top: -20px;";
            proImg = document.createElement("img");
            getPic(data[i], proImg);
            proImg.style = "width: 45px; float: left; border: 1px solid brown; border-radius: 3px; margin: 7px; background-color: white;";
            proImg.onload = function() {
                this.parentElement.parentElement.style.opacity = "1";
            }
            evr.appendChild(proImg);
            
            nme = document.createElement("p");
            nme.style = "margin-top: 23px; color: brown; margin-bottom: 0px; cursor: pointer; float: left; max-width: 110px;";
            nme.innerHTML = data[i];
            nme.onmouseover = function() { this.style.textDecoration = "underline"; }
            nme.onmouseout = function() { this.style.textDecoration = "none"; }
            nme.onclick = function() {
                sessionStorage.removeItem("settings");
                window.location = "../" + this.innerHTML + "/";
            }
            evr.appendChild(nme);
            
            span = document.createElement("span");
            span.style = "color: #999; line-height: 10px; font-size: 12px; float: left; width: 110px; text-align: left;";
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
            if (user[0].following.indexOf(data[off+i]) > -1) {
                fng.style.display = "block";
            } else {
                fol.style.display = "block";
            }
            
            getAttr("scribbles", data[off+i], span);
            evr.appendChild(span);
            evr.appendChild(fng);
            evr.appendChild(fol);
            box.appendChild(evr);
            elem.appendChild(box);
        }
    }
}

function getPic(name, elm) {
    url = "../../php/get.php?typ=proPic&usr=" + name;
    $.ajax({
         type: 'GET',
         data:$(this).serialize(),
         dataType: 'html',
         url: url,
         success: function (d) {
             elm.src = "../../res/usr/" + d;
             //elm.parentElement.parentElement.style.opacity = "1";
         }
    });
}

function config(user) {
    document.getElementById("usrName").style.backgroundColor = "#fff";
    document.getElementById("usrName").innerHTML = user[0].name; //+ ' <span id="usrPosts" style="color: #888; background-color: #ddd; min-height: 20px; min-width: 50px; margin-left: 8px; font-size: 14px; font-family: Helvetica;">Scribbles: ' + user[0].scribbles + '</span>';
    document.getElementById("usrImg").src = "../../res/usr/" + user[0].img;
    width = (window.innerWidth-1200)/2;
    if (width > 0) {
        document.getElementById("usrBtn").style.right = width + "px";
        document.getElementById("usrFng").style.right = width + "px";
        document.getElementById("usrFol").style.right = width + "px"; "px";
        document.getElementById("usrImg").style.marginLeft = width + "px";
        
        document.getElementById("usrDes").style.left = width + 112 + "px";
        document.getElementById("bottom").style.left = width + 105 + "px";
    }
    
    document.getElementById("usrDes").style.backgroundColor = "#fff";
    document.getElementById("usrDes").innerHTML =  user[0].fname + " " + user[0].lname;
    if (auth == true) {
        proPogate();
    }
    document.getElementById("usrFollowers").innerHTML = "Followers: " + (user[0].followers.split(",").length-1);
    document.getElementById("usrFollowing").innerHTML = "Following: " + (user[0].following.split(",").length-1);
    document.getElementById("usrPosts").innerHTML = "Scribbles: " + user[0].scribbles;
    
    document.getElementById("topName").innerHTML = user[0].name;
    document.getElementById("topFol").innerHTML = (user[0].followers.split(",").length-1) + " Followers";
    document.getElementById("topFng").innerHTML = (user[0].following.split(",").length-1) + " Following";
    document.getElementById("topScr").innerHTML = user[0].scribbles + " Scribbles";
    
    divs = document.getElementsByClassName("style");
    for (var j=0; j<divs.length; j++) {
        divs[j].onclick = function() {
//            switchTo(this.id);
//            if (this.id == "cols") {
//                document.getElementById("folSelection").style.display = "block";
//            } else {
//                document.getElementById("folSelection").style.display = "none";
//            }
            if (this.id != "log") {
                sessionStorage.setItem("settings", this.id);
                location.reload();
            } else {
                switchTo(this.id);
            }
        }
    }
    if (auth == true) {
        if(user[0].name == per) {
            document.getElementById("usrBtn").style.display = "block";
            document.getElementById("usrFng").style.display = "none";
            document.getElementById("usrFol").style.display = "none";
            //document.getElementById("profileStuff").style.display = "block";
        } else {
            fng = document.getElementById("usrFng");
            fol = document.getElementById("usrFol");
            if (user[0].followers.indexOf(per) > -1) {
                fng.style.display = "block";
            } else {
                fol.style.display = "block";
            }
            fng.onclick = function() {
                unfollow(user[0].name);
                this.style.display = "none";
                document.getElementById("usrFol").style.display = "block";
            }
            fol.onclick = function() {
                follow(user[0].name);
                this.style.display = "none";
                document.getElementById("usrFng").style.display = "block";
            }
        }
    }
    
    //document.getElementById("includedContent").style.display = "block";
}

function switchTo(id) {
    if (id == "cols" || id == "fol" || id == "fng" || id == "scrs" || id == "coms" || id == "savs" || id == "ups" || id == "downs") {
        divs = document.getElementsByClassName("style");
        for (var j=0; j<divs.length; j++) {
            divs[j].style.backgroundColor = "#fafafa";
            divs[j].childNodes[1].style.backgroundColor = "#aaa";
        }
        div = document.getElementById(id);
        div.style.backgroundColor = "#ddd";
        div.childNodes[1].style.backgroundColor = "brown";
        
        document.getElementById("comD").style.display = "none";
        document.getElementById("savD").style.display = "none";
        document.getElementById("colsD").style.display = "none";
        document.getElementById("folD").style.display = "none";
        document.getElementById("fngD").style.display = "none";
        document.getElementById("upsD").style.display = "none";
        document.getElementById("downsD").style.display = "none";
        if (id == "fol") {
            if (eval(id + "Off") == 0) {
                followers(user);
            }
            sessionStorage.setItem("settings", id);
            document.getElementById("folSelection").style.display = "none";
            document.getElementById(id + "D").style.display = "block";
        } else if (id == "fng") {
            if (eval(id + "Off") == 0) {
                following(user);   
            }
            sessionStorage.setItem("settings", id);
            document.getElementById("folSelection").style.display = "none";
            document.getElementById(id + "D").style.display = "block";
        } else if (id == "scrs" || id == "coms" || id == "savs") {
            sessionStorage.setItem("settings", id);
            port(document.getElementById(id+"D"), "udder");
            document.getElementById("folSelection").style.display = "none";
        } else if (id == "cols") {
            if (scribbles == true && off == 0) {
                getScribbles(sessionStorage.getItem("style"), user[0].name);   
            }
            sessionStorage.setItem("settings", id);
            document.getElementById("folSelection").style.display = "block";
            document.getElementById(id + "D").style.display = "block";
        } else if (id == "ups" || id == "downs") {
            sessionStorage.setItem("settings", id);
            document.getElementById("folSelection").style.display = "none";
            document.getElementById(id + "D").style.display = "block";
            if (eval(id + "Off") == 1) {
                if (id == "ups") {
                    getups(user[0].upvoted);
                } else {
                    getdowns(user[0].downvoted);
                }
            }
        }
    } else if (id == "settings" || id == "statistics" || id == "help") {
        sessionStorage.setItem("settings", id);
        window.location = "../../" + id + "/";
    } else {
        logOut("../../php/leave.php");
    }
}

function port(elm, typ) {
    console.log(elm.innerHTML);
    document.getElementById("colsD").style.display = "none";
    document.getElementById("folD").style.display = "none";
    document.getElementById("fngD").style.display = "none";
    document.getElementById("comD").style.display = "none";
    document.getElementById("savD").style.display = "none";
    document.getElementById("upsD").style.display = "none";
    document.getElementById("downsD").style.display = "none";
    
    if (typ == "norm") {
        por = document.getElementsByClassName("port");
        for (var j=0; j<por.length; j++) {
            por[j].style.borderBottom = "";
            por[j].style.paddingBottom = "5px";
        }

        elm.style.borderBottom = "2px solid brown";   
    }
    
    if (elm.innerHTML == "Scribbles") {
        if (off == 0 && scribbles == true) {
            getScribbles(sessionStorage.getItem("style"), user[0].name);
        }
        document.getElementById("colsD").style.display = "block";
    } else if (elm.innerHTML == "Comments") {
        if (comOff == 0) {
            getCom(user[0].name);
        }
        document.getElementById("comD").style.display = "block";
    } else if (elm.innerHTML == "Saved") {
        if (savOff == 1) {
            getSav(user[0].saves);
        }
        document.getElementById("savD").style.display = "block";
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
                window.location = "../../scribble/" + this.id.substring(4, this.id.length);
            }

            dIv = document.createElement("div");
            dIv.className = "portImg";
            img = document.createElement("img");
            getThumb(data[i].no, img);
            dIv.appendChild(img);   
        }
        
        topBar = document.createElement("div");
        topBar.className = "comBar";
        topBar.innerHTML = '<a href="." class="subText"><strong>' + data[i].author + '</strong></a><p class="subText">' + data[i].points + ' pts</p><p class="subText">' + data[i].date + '</p>';
        
        com = document.createElement("p");
        com.innerHTML = data[i].comment;
        com.style += "float: left; margin-left: 130px;";
        
        if (oc == true) {
            box.appendChild(dIv);
            box.appendChild(topBar);
            box.appendChild(com);
            document.getElementById("comD").appendChild(box);
        } else {
            document.getElementById(parentId).appendChild(topBar);
            document.getElementById(parentId).appendChild(com);
        }
    }
    
    comOff += 30;
}

function createImages(data, offset) {
//    document.getElementById("imgRow").style.display = "block";
    for (var i=0; i<data.length; i++) {
        box = document.createElement("div");
        box.id = data[i].id;
        box.onclick = function() {
            sessionStorage.setItem("scribble", this.id);
            window.location = "../../scribble/" + this.id + "/";
        }
        box.className = "container";
        box.style = "overflow: hidden; visibility: hidden;";
        
        img = document.createElement("img");
        img.className = "image";
        img.onload = function() {
            this.parentElement.style.visibility = "visible";
        }
        img.src = "../../scribble/" + data[i].id + "/" + data[i].img;
        box.appendChild(img);
        
        mid = document.createElement("mid");
        mid.className = "middle";
        mid.onclick = function() {
            alert(data[i].name);
        }
        
        mid.innerHTML = "<strong>" + data[i].name + "</strong> by ";
        if (data[i].anon == 1) {
            mid.innerHTML += "<span style='color: #00FF7F'>anon</span>"; 
        } else {
            mid.innerHTML += "<span style='color: brown'>" + data[i].author + "</span>"; 
        }
        mid.innerHTML += "<p><img src='../../res/ico/upvote.png' style='width:15px; float: left;'><span style='float: left; margin-left: 10px; margin-top: 0px;'>" + data[i].rating + "</span><span style='float: right; margin-left: 10px; margin-top: 0px;'>" + data[i].views + "</span><img src='../../res/ico/views.png' style='width:15px; float: right; margin-top: 0px'></p>";
        
        box.appendChild(mid);
        if (data[i].anon == 0 || per == data[i].author && data[i].anon == 1) {
            if (offset == 1) {
                for (var j=0; j<3; j++) {
                    var points = 0;
                    for (var k=0; k<3; k++) {
                        if (c[j] <= c[k]) {
                            points += 1;
                        }
                    }
        //            console.log(points);
                    if (points == 3) {
                        document.getElementById("c" + (j+offset)).appendChild(box);
                        c[j] += parseInt(getHeight(data, i));
                        break;
                    }
                }   
            } else if (offset == 4) {
                for (var j=0; j<3; j++) {
                    var points = 0;
                    for (var k=0; k<3; k++) {
                        if (h[j] <= h[k]) {
                            points += 1;
                        }
                    }
        //            console.log(points);
                    if (points == 3) {
                        document.getElementById("c" + (j+offset)).appendChild(box);
                        h[j] += parseInt(getHeight(data, i));
                        break;
                    }
                }
            } else if (offset == 7) {
                for (var j=0; j<3; j++) {
                    var points = 0;
                    for (var k=0; k<3; k++) {
                        if (u[j] <= u[k]) {
                            points += 1;
                        }
                    }
        //            console.log(points);
                    if (points == 3) {
                        document.getElementById("c" + (j+offset)).appendChild(box);
                        u[j] += parseInt(getHeight(data, i));
                        break;
                    }
                }
            } else if (offset == 10) {
                for (var j=0; j<3; j++) {
                    var points = 0;
                    for (var k=0; k<3; k++) {
                        if (d[j] <= d[k]) {
                            points += 1;
                        }
                    }
        //            console.log(points);
                    if (points == 3) {
                        document.getElementById("c" + (j+offset)).appendChild(box);
                        d[j] += parseInt(getHeight(data, i));
                        break;
                    }
                }
            }    
        }
        
    }
    if (offset == 1) {
        off += data.length;
    } 
//    else if (offset == 4) {
//        savOff += data.length;
//    } else if (offset == 7) {
//        upsOff += data.length;
//    } else if (offset == 10) {
//        downsOff += data.length;
//    }
}

function feedOff(db) {
    url = "../../php/get.php?typ=pstNum&base=" + db;
    $.ajax({
         type: 'GET',
         data:$(this).serialize(),
         dataType: 'html',
         url: url,
         success: function (d) {
             //console.log("db: " + d);
             ini = d;
         }
    });
}

function getSav(saves) {
    saved = saves.replace(/e/g, "").split(",").reverse();
    console.log(saved);
    if (saved.length > 1) {
        for (var k=0; k<saved.length; k++) {
            if (saved.length > k+savOff-1 && saved[k+savOff-1] != "") {
                url = "../../php/get.php?typ=sing&id=" + saved[k+savOff-1];
                $.ajax({
                     type: 'GET',
                     data:$(this).serialize(),
                     dataType: 'html',
                     url: url,
                     success: function (d) {
                         data = JSON.parse("["+d+"]");
                         savOff += 1;
                         createImages(data, 4);
                     }
                });   
            }
        }   
    } else if (savOff == 1) {
        document.getElementById("savD").innerHTML += "<h1 style='color: brown; text-align: center; margin-top: -180px;'>No Saved</h1>";
        savOff = -1;
    }
}

function getups(ups) {
    voted = ups.replace(/e/g, "").split(",").reverse();
    console.log(voted.length);
    if (voted.length > 1) {
        for (var k=0; k<voted.length; k++) {
            if (voted.length > k+upsOff-1 && voted[k+upsOff-1] != "") {
                url = "../../php/get.php?typ=sing&id=" + voted[k+upsOff-1];
                $.ajax({
                     type: 'GET',
                     data:$(this).serialize(),
                     dataType: 'html',
                     url: url,
                     success: function (d) {
                         data = JSON.parse("["+d+"]");
                         upsOff += 1;
                         createImages(data, 7);
                     }
                });   
            }
        }   
    } else if (upsOff == 1) {
        document.getElementById("upsD").innerHTML += "<h1 style='color: brown; text-align: center; margin-top: -200px;'>No Upvoted Scribbles</h1>";
        upsOff = -1
    }
}

function getdowns(downs) {
    voted = downs.replace(/e/g, "").split(",").reverse();
    console.log(voted.length);
    if (voted.length > 1) {
        for (var k=0; k<voted.length; k++) {
            if (voted.length > k+downsOff-1 && voted[k+downsOff-1] != "") {
                url = "../../php/get.php?typ=sing&id=" + voted[k+downsOff-1];
                $.ajax({
                     type: 'GET',
                     data:$(this).serialize(),
                     dataType: 'html',
                     url: url,
                     success: function (d) {
                         data = JSON.parse("["+d+"]");
                         downsOff += 1;
                         createImages(data, 10);
                     }
                });
            }
        }   
    } else if (downsOff == 1) {
        document.getElementById("downsD").innerHTML += "<h1 style='color: brown; text-align: center; margin-top: -200px;'>No Downvoted Scribbles</h1>";
        downsOff = -1
    }
}

function getHeight(data, i) {
    var height = (data[i].height * 100)/data[i].width;
    return height;
}

$('#myInput').on("keyup", function(e) {
    if (e.keyCode == 13) {
        window.location = "../../search?q=" + this.value;
    }
});

$(window).scroll(function() {
    if($(window).scrollTop() + $(window).height() >= $(document).height()) {
        if (document.getElementById("colsD").style.display != "none") {
            getScribbles(sessionStorage.getItem("style"), user[0].name);   
        } else if (document.getElementById("folD").style.display != "none") {
            followers(user);
        } else if (document.getElementById("fngD").style.display != "none") {
            following(user);
        } else if (document.getElementById("savD").style.display != "none") {
            getSav(user[0].saves);
        } else if (document.getElementById("upsD").style.display != "none") {
            getups(user[0].upvoted);
        } else if (document.getElementById("downsD").style.display != "none") {
            getdowns(user[0].downvoted);
        } else {
            getCom(user[0].name);
        }
    }
    
    if ($(window).scrollTop() > 180) {
        document.getElementById("stickyBoi").style.display = "block";
    } else {
        document.getElementById("stickyBoi").style.display = "none";
    }
});

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

function getThumb(id, elem) {
    url = "../../php/get.php?typ=sing&id=" + id;
    $.ajax({
         type: 'GET',
         data:$(this).serialize(),
         dataType: 'html',
         url: url,
         success: function (d) {
             data = JSON.parse(d);
             elem.src = "../../scribble/" + data['id'] + "/" + data['img'];
         }
    });
}

function follow(user) {
    url = "../../php/change.php?typ=fol&per=" + user;
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
    url = "../../php/change.php?typ=unfol&per=" + user;
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