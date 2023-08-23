var currColor = "#df4b26";
var globalSize = 5;

var clickX = new Array();
var clickY = new Array();
var color = new Array();
var size = new Array();
var clickDrag = new Array();
var paint;

function search(el) {
    if (this.event.keyCode == 13) {
        window.location = "../../search?q=" + el.value;
    }
}

window.onload = function() {
    proPogate();
    document.getElementById("cWidth").value = Math.floor(Math.random() * 550) + 250;
    
    var canvasDiv = document.getElementById('canvasDiv');
    canvas = document.createElement('canvas');
    canvas.setAttribute('width', document.getElementById("cWidth").value);
    canvas.setAttribute('height', document.getElementById("cHeight").value);
    canvas.setAttribute('id', 'canvas');
    canvas.style.backgroundColor = "#fff";
    canvas.style.marginLeft = "100px";
    canvasDiv.appendChild(canvas);
    if(typeof G_vmlCanvasManager != 'undefined') {
        canvas = G_vmlCanvasManager.initElement(canvas);
    }
    context = canvas.getContext("2d");

    $('#canvas').mousedown(function(e){
        var mouseX = e.pageX - this.offsetLeft;
        var mouseY = e.pageY - this.offsetTop;

        paint = true;
        addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop);
        redraw();
    });

    $('#canvas').mousemove(function(e){
        if(paint){
            addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop, true);
            redraw();
        }
    });

    $('#canvas').mouseup(function(e){
        paint = false;
    });

    $('#canvas').mouseleave(function(e){
        paint = false;
    });  
    
    document.getElementById("sizeTool").onchange = function() {
    globalSize = document.getElementById("sizeTool").value; }
    document.getElementById("pen").onclick = function() { selectTool("p"); }
    document.getElementById("era").onclick = function() { selectTool("e"); }
    document.getElementById("penu").onclick = function() { selectTool("p"); }
    document.getElementById("erau").onclick = function() { selectTool("e"); }
    document.getElementById("clearBtn").onclick = function() { clearScreen(); }
    
    setDrawing();
    getStyles();
    
    // Get the modal
    var modal = document.getElementById("myModal");
    var btn = document.getElementById("pub");
    var span = document.getElementById("ret");
    btn.onclick = function() {
        modal.style.display = "block";
        document.getElementById("pic").src = canvas.toDataURL();
        validateCanv();
        //prepareImg();
    }
    span.onclick = function() {
        modal.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
        if (event.target.id != "pro-btn" && event.target.id != "pro-drop") {
            $("#pro-drop").animate({opacity: '0'}, "fast");
            document.getElementById("pro-drop").style.display = "none";
            document.getElementById("tri-cont").style.display = "none";
            $("#tri-cont").animate({opacity: '0'}, "fast");
        }
    }
}

function edit(typ, val) {
    if (typ == "name") {
        document.getElementById("name").value = val;
        document.getElementById("scrName").value = val;
        document.getElementById("pubName").value = val;
    } else if (typ == "style") {
        document.getElementById("scrGenre").value = val;
        document.getElementById("genre").value = val;
        document.getElementById("scrGenrePub").value = val;
    }
    validateCanv();
}

function validateCanv() {
    err = document.getElementById("errors");
    publish = true;
    
    err.innerHTML = "";
    if (document.getElementById("cWidth").value < 250 || document.getElementById("cHeight").value < 250) {
        err.innerHTML += "Scribble minimum size is 250x250<br>";
        publish = false;
    }
    if (document.getElementById("scrName").value == "") {
        err.innerHTML += "Scribble must have a name<br>";
        publish = false;
    }
    if (document.getElementById("scrName").value.length > 50) {
        err.innerHTML += "Scribble's name is too long<br>";
        publish = false;
    }
    if (clickX.length == 0) {
        err.innerHTML += "Scribble must have content<br>";
        publish = false;
    }
}

function addClick(x, y, dragging)
{
    clickX.push(x);
    clickY.push(y);
    clickDrag.push(dragging);
    color.push(currColor);
    size.push(globalSize);
}

function redraw(){
//    context.clearRect(0, 0, context.canvas.width, context.canvas.height); // Clears the canvas

    context.lineJoin = "round";

//    for(var i=0; i < clickX.length; i++) {		
//        context.strokeStyle = color[i];
//        context.lineWidth = size[i];
//        context.beginPath();
//        
//        if(clickDrag[i] && i){
//            context.moveTo(clickX[i-1], clickY[i-1]);
//        }else{
//            context.moveTo(clickX[i]-1, clickY[i]);
//        }
//        context.lineTo(clickX[i], clickY[i]);
//        context.closePath();
//        context.stroke();
//    }
    context.strokeStyle = color[color.length-1];
    context.lineWidth = size[size.length-1];
    context.beginPath();

    if(clickDrag[clickX.length-1] && clickX.length-1){
        context.moveTo(clickX[clickX.length-2], clickY[clickY.length-2]);
    }else{
        context.moveTo(clickX[clickX.length-1]-1, clickY[clickY.length-1]);
    }
    context.lineTo(clickX[clickX.length-1], clickY[clickY.length-1]);
    context.closePath();
    context.stroke();
}

function setDrawing() {
    canvas = document.getElementById("canvas");
    if (document.getElementById("cWidth").value > 750) {
        document.getElementById("cWidth").value = 750;
    }
    if (document.getElementById("cHeight").value > 450) {
        document.getElementById("cHeight").value = 450;
    }
//    if (document.getElementById("cWidth").value < 250) {
//        document.getElementById("cWidth").value = 250;
//    }
//    if (document.getElementById("cHeight").value < 250) {
//        document.getElementById("cHeight").value = 250;
//    }
    
    canvas.width = document.getElementById("cWidth").value;
    canvas.height = document.getElementById("cHeight").value;
    
    left = Math.floor((750 - canvas.width)/2);
    up = Math.floor((450 - canvas.height)/2);
    
    canvas.style.marginLeft = left + "px";
    canvas.style.marginTop = up + "px";
    redraw();
}

function clearScreen() {
    context.clearRect(0, 0, context.canvas.width, context.canvas.height);
    
    clickX = [];
    clickY = [];
    clickDrag = [];
    color = [];
    size = [];
    paint;
}

function colorDivSet(color) {
    document.getElementById("selectedColor").style.backgroundColor = color.style.backgroundColor;
    currColor = color.style.backgroundColor;
}

function selectTool(mod) {
    if (mod == "p") {
        document.getElementById("penDiv").style.display = "block";
        document.getElementById("eraDiv").style.display = "none";
        currColor = document.getElementById("selectedColor").style.backgroundColor;
    } else {
        document.getElementById("penDiv").style.display = "none";
        document.getElementById("eraDiv").style.display = "block";
        currColor = "#ffffff";
    }
}

function getStyles() {
    url = "../../php/get.php?typ=sty";
    $.ajax({
         type: 'GET',
         data:$(this).serialize(),
         dataType: 'html',
         url: url,
         success: function (d) {
             styles = JSON.parse(d);
             createStyles(styles, "scrGenrePub");
             createStyles(styles, "scrGenre");
         }
    });
}

function createStyles(styles, elem) {
    for (var i=0; i<styles.length; i++) {
        if (i > 2) {
            box = document.createElement("option");
            box.localName = styles[i].style;

            p = document.createElement("p");
            p.innerHTML = styles[i].style;

            box.appendChild(p);
            document.getElementById(elem).appendChild(box);
            if (styles[i].style == sessionStorage.getItem("style")) {
                document.getElementById(elem).value = styles[i].style;
            }
        }
    }
}