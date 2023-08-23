<?php
    session_start();
    if (isset($_SESSION['auth'])) {
        echo "<script> var auth = true; </script>";
    } else {
        echo "<script> var auth = false; </script>";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $_SESSION['fname'] . " " . $_SESSION['lname']; ?> - Scrilib</title>
        <meta charset="utf-8">
        <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1">
        
        <link rel="icon" type="image/png" href="../../res/ast/fav.ico">
        <link href="../../css/style.css" rel="stylesheet" type="text/css">
        <link href="../../css/nav.css" rel="stylesheet" type="text/css">
        <link href="../../css/folio.css" rel="stylesheet" type="text/css">
        <link href="../../css/hearth.css" rel="stylesheet" type="text/css">
        
        <script src="../../js/script.js"></script>
        <script src="../../js/ajax.min.js"></script>
        <script src="../../js/folio.js"></script>
        <script>
            var user = "<?php echo $_SESSION['user'] ?>";
        </script>
    </head>
    <body>
        <div id="nav">
            <ul>
                <p class="title" onclick="window.location = '../../'"><strong>Scrilib</strong></p>
                <li class="s"><a class="active" href="../../">Hearth</a></li>
                <li class="u"><a href="../archive">Archive</a></li>
                <?php
                    if (isset($_SESSION['auth'])) {
                        if ($_SESSION['auth'] == false) {
                            echo '<button class="b2" style="float: right; margin-top: 11px;" onclick = "window.location=\'./p/signup/\'">Sign Up</button>
                            <button class="b1" style="float: right; margin-top: 11px;" onclick="window.location=\'./p/signin/\'">Log In</button>';
                        } else {
                            echo '<a id="pro" href="."><img src="../../res/ast/fav.ico" style="float: right; height: 32px; width: 32px; border: 1px solid #bbb; border-radius: 3px; margin-top: 10px; margin-left: 10px; cursor: pointer;"></a>
                            <button class="b1" style="float: right; margin-top: 11px;" onclick="tripto(\'../../p/canvas/\')">Scribble</button>';
                        }
                    } else {
                        echo '<button class="b2" style="float: right; margin-top: 11px;" onclick = "window.location=\'./p/signup/\'">Sign Up</button>
                        <button class="b1" style="float: right; margin-top: 11px;" onclick="window.location=\'./p/signin/\'">Log In</button>';
                    }
                ?>
                <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search Scrilib">
            </ul>
        </div>
        
        <div id="view" style="position: absolute;">
            <div id="styles" class="left">
                <div id="cols" class="style">
                    <div class="imgDiv">
                        <img src="../../res/ico/feed.png">
                    </div>
                    <p>Scribbles</p>
                </div>
                <div id="fol" class="style" style="margin-top: -10px;">
                    <div class="imgDiv">
                        <img src="../../res/ico/acc.png">
                    </div>
                    <p>Followers</p>
                </div>
                <div id="fng" class="style" style="margin-top: -10px;">
                    <div class="imgDiv">
                        <img src="../../res/ico/acc.png">
                    </div>
                    <p>Following</p>
                </div>
                <hr>
                <div id="settings" class="style" style="margin-top: -10px;">
                    <div class="imgDiv">
                        <img src="../../res/ico/set.png">
                    </div>
                    <p>Settings and Privacy</p>
                </div>
                <div id="help" class="style" style="margin-top: -10px;">
                    <div class="imgDiv">
                        <img src="../../res/ico/hel.png">
                    </div>
                    <p>Help</p>
                </div>
                <div id="statistics" class="style" style="margin-top: -10px;">
                    <div class="imgDiv">
                        <img src="../../res/ico/per.png">
                    </div>
                    <p>Statistics</p>
                </div>
                <div id="log" class="style" style="margin-top: -10px;">
                    <div class="imgDiv">
                        <img src="../../res/ico/log.png">
                    </div>
                    <p>Log Out</p>
                </div>
            </div>
            <div class="right" style="display: none;">
                
            </div>
            <div class="center" id="feed">
                <div class="top" style="height: 120px; max-height: 120px; position: relative; border-radius: 3px 3px 0px 0px;">
                    <button id="usrBtn" class="b2" style="position: absolute; top: 10px; right: 5px;">Scribble</button>
                    <img id="usrImg" src="../../res/ast/fav.ico" style="width: 100px; height: 100px; margin: 10px; border: 1px solid brown; border-radius: 3px; float: left;">
                    <h2 id="usrName" style="font-family: Georgia; line-height: 10px; border-radius: 2px; background-color: #ddd; float: left; min-height: 20px; min-width: 150px;"></h2>
                    <p id="usrDes" style="color: #666; margin-top: -25px; border-radius: 2px; background-color: #ddd; min-height: 20px; min-width: 450px; max-width: 250px; float: left;"></p>
                    
                    <div id="bottom" style="position: absolute; bottom: -7px; left: 115px; width: 460px; border-radius: 2px;">
                        <div style="width: 150px; float: left; margin-left: 8px;">
                            <img src="../../res/ico/acc.png" style="width: 20px; float: left; background-color: #ddd; border: 1px solid #bbb; border-radius: 3px; bottom: 15px; position: absolute; margin-left: 8px; margin-left: 0px;">
                            <p id="usrFollowers" style="float: left; color: #888; margin-left: 26px;">Followers: 000</p>
                        </div>
                        
                        <div style="width: 150px; margin: auto;">
                            <img src="../../res/ico/acc.png" style="width: 20px; float: left; background-color: #ddd; border: 1px solid #bbb; border-radius: 3px; bottom: 15px; position: absolute; margin-left: 0px;">
                            <p id="usrFollowing" style="float: left; color: #888; margin-left: 26px;">Following: 000</p>
                        </div>
                        
                        <div style="width: 150px; float: right;">
                            <img src="../../res/ico/scr.png" style="width: 20px; float: left; background-color: #ddd; border: 1px solid #bbb; border-radius: 3px; bottom: 15px; position: absolute; margin-left: 0px;">
                            <p id="usrPosts" style="float: left; color: #888; margin-left: 26px;">Scribbles: 000</p>
                        </div>
                    </div>
                </div>
                
                <div id="colsD" class="row" style="margin-top: 0p;">
                    <div id="c1" class="column"></div>
                    <div id="c2" class="column"></div>
                    <div id="c3" class="column"></div>
                </div>
                <div id="folD" class="row" style="display: none;">
                    
                </div>
                <div id="fngD" class="row" style="display: none;">
                    
                </div>
            </div>
        </div>
        
    </body>
</html>