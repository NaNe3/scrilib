<?php
    session_start();
    if ($_SESSION['auth'] == false || isset($_SESSION['auth']) == false) {
        echo '<script>window.location = "../signin/";</script>';
        //echo $_SESSION["sauth"];
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Scrilib | Draw Your Heart Out</title>
        <meta charset="utf-8">
        <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1">
        
        <link rel="icon" type="image/png" href="../../res/ast/fav.ico">
        <link href="../../css/style.css" rel="stylesheet" type="text/css">
        <link href="../../css/nav.css" rel="stylesheet" type="text/css">
        <link href="../../css/canvas.css" rel="stylesheet" type="text/css">
        
        <script src="../../js/script.js"></script>
        <script src="../../js/ajax.min.js"></script>
        <script src="../../js/draw.js"></script>
        <script>
            var user = "<?php
                if (isset($_SESSION['user'])) {
                    echo $_SESSION['user'];
                } else {
                    echo "EL!";
                }
            ?>";
        </script>
    </head>
    <body>
        
        <div id="myModal" class="modal">
            <div class="modal-content">
<!--                <span class="close">&times;</span>-->
                <h2 style="color: brown; text-align: center; border-bottom: 2px solid brown;">Publish to Scrilib</h2>
                <img id="pic" style="width: 280px; float: right; border: 1px solid #bbb; margin-top: 10px; border-radius: 3px;">
                <label>NAME</label><br>
                <input id="pubName" type="text" placeholder="Name" value="MyScribble" style="margin-top: 0px; width: 250px;" oninput="edit('name', this.value)"><br>
                <label>STYLE</label><br>
                <select id="scrGenrePub" value="all" style="width: 250px; margin-left: 10px; margin-top: 0px; padding-left: 10px;" oninput="edit('style', this.value)"></select>
                <p id="errors" style="color: red; margin-left: 10px; width: 203px; font-size: 12px;"></p>
                
                <br><br>
                <div id="action">
                    <button id="ret" class="b2" style="width: 115px;">Return</button>
                    <button class="b1" onclick="prepareImg()" style="width: 115px;">Publish</button>
                </div>
            </div>
        </div>
        
        <div id="nav">
            <ul>
                <p class="title" onclick="window.location = '../../'"><strong>Scrilib</strong></p>
                <li class="u"><a class="active" href="../../">Hearth</a></li>
                <li class="u"><a href="../../archive/">Archive</a></li>
                <?php
                    if (isset($_SESSION['auth'])) {
                        if ($_SESSION['auth'] == false) {
                            echo '<button class="b2" style="float: right; margin-top: 11px;" onclick = "window.location=\'./p/signup/\'">Sign Up</button>
                            <button class="b1" style="float: right; margin-top: 11px;" onclick="window.location=\'./p/signin/\'">Log In</button>';
                        } else {
                            echo '<div id="pro-cont" style="position: relative;">
                            <img id="pro-btn" src="../../res/usr/' . $_SESSION['src'] . '" style="float: right; height: 32px; width: 32px; border: 1px solid #bbb; border-radius: 3px; margin-top: 10px; margin-left: 10px; cursor: pointer;">
                            <div id="tri-cont" class="triangle-up" style="opacity: 0;"></div>
                            <div id="pro-drop" style="opacity: 0;">
                                <img src="../../res/usr/' . $_SESSION['src'] . '" style="width: 65px; border-radius: 300px; margin: 7px 7px; float: left; background-color: white;">
                                <div class="pro-selection" style="border-bottom: 1px solid #ddd; height: 65px;" onclick="window.location=\'../../user/' . $_SESSION['user'] . '/\';">
                                    <p style="color: brown; font-size: 20px; margin: 0px 0px 0px 20px; padding-top: 15px;">' . $_SESSION['fname'] . ' ' . $_SESSION['lname'] . '</p>
                                    <p style="font-size: 12px; color: #bbb; margin: 0px 0px 0px 20px;">' . $_SESSION['user'] . '</p>
                                </div>
                                <div class="pro-selection" style="margin-top: 15px;"  onclick="window.location=\'../../gossamer/\'">
                                    <img src="../../res/ico/web.png" style="width: 25px; margin: 3px 5px 3px 10px; float: left;">
                                    <p style="color: #aaa; margin: 0px 20px; padding-top: 7px;">Gossamer</p>
                                </div>
                                <div class="pro-selection" style="margin-bottom: 10px;"  onclick="window.location=\'../../statistics/\'">
                                    <img src="../../res/ico/stats.png" style="width: 25px; margin: 3px 5px 3px 10px; float: left;">
                                    <p style="color: #aaa; margin: 0px 20px; padding-top: 7px;">Stats</p>
                                </div><hr>

                                <div class="pro-selection" onclick="window.location=\'../../settings/\'" style="margin-top: 10px;">
                                    <img src="../../res/ico/set.png" style="width: 25px; margin: 3px 5px 3px 10px; float: left;">
                                    <p style="color: #aaa; margin: 0px 20px; padding-top: 7px;">Settings</p>
                                </div>
                                <div class="pro-selection" onclick="window.location=\'../../help/\'">
                                    <img src="../../res/ico/hel.png" style="width: 25px; margin: 3px 5px 3px 10px; float: left;">
                                    <p style="color: #aaa; margin: 0px 20px; padding-top: 7px;">Help</p>
                                </div>
                                <div class="pro-selection" style="margin-bottom: 10px;" onclick="window.location=\'../../display/\'">
                                    <img src="../../res/ico/app.png" style="width: 25px; margin: 3px 5px 3px 10px; float: left;">
                                    <p style="color: #aaa; margin: 0px 20px; padding-top: 7px;">Appearance</p>
                                </div><hr>

                                <div class="pro-selection" onclick="logOut(\'../../php/leave.php\');" style="margin-top: 10px;">
                                    <img src="../../res/ico/log.png" style="width: 25px; margin: 3px 5px 3px 10px; float: left;">
                                    <p style="color: #aaa; margin: 0px 20px; padding-top: 7px;">Log Out</p>
                                </div>
                            </div>
                        </div><button class="b1" style="float: right; margin-top: 11px;" onclick="tripto(\'../../p/canvas/\')">Scribble</button>';
                        }
                    } else {
                        echo '<button class="b2" style="float: right; margin-top: 11px;" onclick = "window.location=\'./p/signup/\'">Sign Up</button>
                        <button class="b1" style="float: right; margin-top: 11px;" onclick="window.location=\'./p/signin/\'">Log In</button>';
                    }
                ?>
                <input type="text" id="myInput" placeholder="Search Scrilib" onkeyup="search(this)">
            </ul>
        </div>
        <div id="canvView">
            <div id="right">
                <div class="box">
                    <div id="tabBar">
                        <div id="penDiv" style="margin-left: 19px;">
                            <button id="pen" class="c1" type="button" style="margin-top: 8px;">Pencil</button>
                            <button  id="era" class="c2" style="margin-top: 8px;" type="button">Eraser</button>
                        </div>
                        <div id="eraDiv" style="display: none; margin-left: 17px;">
                            <button id="penu" class="c2" type="button" style="margin-top: 8px;">Pencil</button>
                            <button  id="erau" class="c1" style="margin-top: 8px;" type="button">Eraser</button>
                        </div>
                    </div>
                    <input id="sizeTool" type="number" min="1" max="500" style="width: 200px;" value ="5">
                    <div id="colors">
                        <div class="color" style="background-color: #C0C0C0;" onclick="colorDivSet(this)"></div><div class="color" style="background-color: #808080;" onclick="colorDivSet(this)"></div><div class="color" style="background-color: #000;" onclick="colorDivSet(this)"></div><div class="color" style="background-color: #FF0000;" onclick="colorDivSet(this)"></div><div class="color" style="background-color: #800000;" onclick="colorDivSet(this)"></div><div class="color" style="background-color: #df4b26;" onclick="colorDivSet(this)"></div><div class="color" style="background-color: #FFA500;" onclick="colorDivSet(this)"></div><div class="color" style="background-color: #FFFF00;" onclick="colorDivSet(this)"></div><div class="color" style="background-color: #808000;" onclick="colorDivSet(this)"></div><div class="color" style="background-color: #00FF00;" onclick="colorDivSet(this)"></div><div class="color" style="background-color: #008000;" onclick="colorDivSet(this)"></div><div class="color" style="background-color: #00FFFF;" onclick="colorDivSet(this)"></div><div class="color" style="background-color: #008080;" onclick="colorDivSet(this)"></div><div class="color" style="background-color: #0000FF;" onclick="colorDivSet(this)"></div><div class="color" style="background-color: #000080;" onclick="colorDivSet(this)"></div><div class="color" style="background-color: #FF00FF;" onclick="colorDivSet(this)"></div><div class="color" style="background-color: #800080;" onclick="colorDivSet(this)"></div>
                        
                        <br><br><br><br><br>
                        <div id="selectedColor" style="width: 200px; height: 30px; background-color: #df4b26; border: 1px solid brown;"></div>
                    </div>
                </div>
                <div class="box" style="margin-top: 20px; width: 100%; height: 70px; float: right; margin-right: 8px; padding-top: 15px;">
                    <span style="float: left; margin-left: 10px; font-size: 10px; line-height: 0px;">WIDTH</span>
                    <span style="float: left; margin-left: 120px; font-size: 10px; line-height: 0px;">HEIGHT</span>
                    <input id="cWidth" type="number" style="width: 91px;" min="100" max="750" value="450" oninput="setDrawing()"><input id="cHeight" type="number" style="width: 91px;" min="100" max="450" value="450" oninput="setDrawing()">
                </div>
                <div style="margin-top: 20px; width: 100%; float: right; margin-right: 8px; border-top: 1px solid #666; padding-top: 10px;">
                    <form id="leForm" method="post" action="../../php/post.php">
                        <input name="check" type="checkbox" style="margin-top: 10px;"><span style="color: #666;">Post Anonymously</span>
                        
                        <input name="name" id="name" type="text" style="display: none;">
                        <input name="genre" id="genre" type="text" style="display: none;">
                        <input name="height" id="height" type="text" style="display: none;">
                        <input name="width" id="width" type="text" style="display: none;">
                        
                        <input id="inp_img" name="img" type="hidden" value="" style="display: none;">
                        <input id="bt_upload" type="submit" value="Upload" style="display: none;">
                    </form>
                    
                    <button id="pub" class="b1" style="margin-top: 8px; width: 210px;">Publish</button>
                    
                    <p style="text-align: center; margin: 10px 15px; color: #666;">Ensure that your scribble complies to the <a href="#">posting policy</a></p>
                </div>
            </div>
            <div id="drawContainer" style="overflow: hidden;">
                <div id="tabBar">
                    <input id="scrName" type="text" placeholder="Scribble Name" value="MyScribble" style="margin-top: 8px;" oninput="edit('name', this.value)">
                    
                    <select id="scrGenre" value="all" oninput="edit('style', this.value)">
                        
                    </select>
                    
                    <button id="clearBtn" class="b1" type="button" style="float: right; margin-top: 8px;">Clear</button>
                    
                    <div style="float: right; margin-right: 20px; padding-right: 20px; border-right: 1px solid #666; margin-top: 10px; height: 30px;">
                        <button class="b2" type="button" style="margin-top: -2px;">Upload</button>
                        <button class="b1" type="button" style="margin-top: -2px;">Download</button>
                    </div>
                </div>
                <div id="canvasDiv" style="background-color: #bbb; height: 450px;">
                    
                </div>
            </div>
        </div>
        
    </body>
</html>