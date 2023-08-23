//var tabNum = 0;
//var canvases = "[]";
//
//window.onload = function() {
//    createTab();
//}
//
//function createTab() {
//    console.log("CREATING A TAB");
//    var canvasDiv = document.getElementById('canvasDiv');
//    
//    tab = document.createElement("div");
//    tab.className = "tab";
//    tab.id = "Scribble" + (tabNum+1) + "Tab";
//    console.log(tab.id);
//    document.getElementById("tabBar").appendChild(tab);
//    
//    canvas = document.createElement('canvas');
//    canvas.setAttribute('width', 750);
//    canvas.setAttribute('height', 450);
//    canvas.setAttribute('id', "Scribble" + (tabNum+1));
//    "Scribble" + (tabNum+1);
//    canvas.style.backgroundColor = "red";
//    
//    canvas.onmousedown = function(e) {
//        var mouseX = e.pageX - this.offsetLeft;
//        var mouseY = e.pageY - this.offsetTop;
//        
//        var canvas = getObj(this.id);
//        console.log(canvas.paint);
//        canvas.paint = false;
//        console.log(canvas.paint);
//        canvases = JSON.stringify(canv);
//        //paint  = true;
//        addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop);
//        redraw();
//    }
//    
//    canvas.onmousemove = function(e) {
//        if(paint){
//            addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop, true, this.id);
//            redraw(this.id);
//        }
//    }
//    
//    canvas.onmouseup = function(e) {
//        var canvas = getObj(this.id);
//        canvas.paint = false;
//        canvases = JSON.stringify(canv);
//        
//        //paint = false;
//    }
//    
//    canvas.onmouseout = function(e) {
//        var canvas = getObj(this.id);
//        console.log(canvas);
//        canvas.paint = false;
//        canvases = JSON.stringify(canv);
//    }
//    
//    canvasDiv.appendChild(canvas);
//    
//    if(typeof G_vmlCanvasManager != 'undefined') {
//        canvas = G_vmlCanvasManager.initElement(canvas);
//    }
//    context = canvas.getContext("2d");
//    
////    $('#Scribble' + (tabNum+1)).mousedown(function(e){
////        var mouseX = e.pageX - this.offsetLeft;
////        var mouseY = e.pageY - this.offsetTop;
////        
////        var canvas = getObj(this.id);
////        canvas.paint = false;
////        canvases = JSON.stringify(canv);
////        //paint  = true;
////        addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop);
////        redraw();
////    });
//
////    $('#Scribble' + (tabNum+1)).mousemove(function(e){
////        if(paint){
////            addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop, true, this.id);
////            redraw(this.id);
////        }
////    });
//
////    $('#Scribble' + (tabNum+1)).mouseup(function(e){
////        var canvas = getObj(this.id);
////        canvas.paint = false;
////        canvases = JSON.stringify(canv);
////        
////        //paint = false;
////    });
////
////    $('#Scribble' + (tabNum+1)).mouseleave(function(e){
////        var canvas = getObj(this.id);
////        canvas.paint = false;
////        canvases = JSON.stringify(canv);
////    });
//    
//    var clickX = new Array();
//    var clickY = new Array();
//    var clickDrag = new Array();
//    var paint;
//    
//    canv = JSON.parse(canvases);
//    canv.push({"clickX": clickX, "clickY": clickY, "clickDrag": clickDrag, "paint": paint});
//    canvases = JSON.stringify(canv);
//    
//    console.log(canvases);
//}
//
//function getObj(id) {
//    //console.log("GET THE ID");
//    canv = JSON.parse(canvases);
////    console.log(id);
////    console.log(id.substring(8, id.length)-1);
////    console.log(canv[id.substring(8, id.length)-1]);
//    return canv[id.substring(8, id.length)-1];
//}
//
//function addClick(x, y, dragging, id) {
//    var canvas = getObj(id);
//    canvas.clickX.push(x);
//    canvas.clickY.push(y);
//    canvas.clickDrag.push(dragging);
//    
//    canvases = JSON.stringify(canv);
//}
//
//function redraw(id){
//    context = document.getElementById(id).getContext("2d");
//    
//    context.clearRect(0, 0, context.canvas.width, context.canvas.height); // Clears the canvas
//
//    context.strokeStyle = "#df4b26";
//    context.lineJoin = "round";
//    context.lineWidth = 5;
//    
//    var canvas = getObj(id);
//    for(var i=0; i < canvas.clickX.length; i++) {		
//        context.beginPath();
//        if(canvas.clickDrag[i] && i){
//            context.moveTo(canvas.clickX[i-1], canvas.clickY[i-1]);
//        }else{
//            context.moveTo(canvas.clickX[i]-1, canvas.clickY[i]);
//        }
//        context.lineTo(canvas.clickX[i], canvas.clickY[i]);
//        context.closePath();
//        context.stroke();
//    }
//    canvases = JSON.stringify(canv);
//}