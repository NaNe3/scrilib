<?php
    session_start();
//    
//    global $color;
//    if (isset($_SESSION['user'])) {
//        $servername = "localhost";
//        $username = "root";
//        $password = "";
//        $dbname = "scrilib";
//        $conn = new mysqli($servername, $username, $password, $dbname);
//        // Check connection
//        if ($conn->connect_error) {
//            die("Connection failed: " . $conn->connect_error);
//        }
//        $sql = "SELECT color FROM users WHERE name='" . $_SESSION['user'] . "'";
//        $result = $conn->query($sql) or die($conn->error);
//        $color = implode($result->fetch_assoc());
//    } else {
//        $color = "brown";
//    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Scrilib | Your New Home</title>
        <meta charset="utf-8">
        <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1" />
        
        <link rel="icon" type="image/png" href="./res/ast/fav.ico">
        <link href="css/style.css" rel="stylesheet" type="text/css">
        <link href="css/nav.css" rel="stylesheet" type="text/css">
        <link href="css/hearth.css" rel="stylesheet" type="text/css">
        <script src="js/script.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
        <script src="js/ajax.min.js"></script>
        <script>
            var user = "<?php echo $_SESSION['user'] ?>";
        </script>
        <script src="js/hearth.js"></script>
    </head>
    <body><!--ng-app="" ng-init="first='<?php //echo $color; ?>'"-->
<!--        <h1 class="title" style="margin-bottom: -50px;" onclick="window.location='index.php'"><span style="color: brown">Scrilib</span></h1>-->
        <div id="nav" style="box-shadow: 0 3px 2px -2px rgba(200,200,200,0); border: 0;">
            <ul style="width: 95%;">
                <p class="title" onclick="window.location = './'"><strong>Scrilib</strong></p>
                <li class="s"><a class="active" href=".">Hearth</a></li>
                <li class="u"><a href="./archive">Archive</a></li>
                <?php
                    if (isset($_SESSION['auth'])) {
                        if ($_SESSION['auth'] == false) {
                            echo '<button class="b2" style="float: right; margin-top: 11px;" onclick = "window.location=\'./p/signup/\'">Sign Up</button>
                            <button class="b1" style="float: right; margin-top: 11px;" onclick="window.location=\'./p/signin/\'">Log In</button>';
                        } else {
                            echo '<div id="pro-cont" style="position: relative;">
                            <img id="pro-btn" src="./res/usr/' . $_SESSION['src'] . '" style="float: right; height: 32px; width: 32px; border: 1px solid #bbb; border-radius: 3px; margin-top: 10px; margin-left: 10px; cursor: pointer;">
                            <div id="tri-cont" class="triangle-up" style="opacity: 0;"></div>
                            <div id="pro-drop" style="opacity: 0;">
                                <img src="res/usr/' . $_SESSION['src'] . '" style="width: 65px; border-radius: 300px; margin: 7px 7px; float: left; background-color: white;">
                                <div class="pro-selection" style="border-bottom: 1px solid #ddd; height: 65px;" onclick="window.location=\'./user/' . $_SESSION['user'] . '/\';">
                                    <p style="color: brown; font-size: 20px; margin: 0px 0px 0px 20px; padding-top: 15px;">' . $_SESSION['fname'] . ' ' . $_SESSION['lname'] . '</p>
                                    <p style="font-size: 12px; color: #bbb; margin: 0px 0px 0px 20px;">' . $_SESSION['user'] . '</p>
                                </div>
                                <div class="pro-selection" style="margin-top: 15px;"  onclick="window.location=\'./gossamer/\'">
                                    <img src="res/ico/scr.png" style="width: 25px; margin: 3px 5px 3px 10px; float: left;">
                                    <p style="color: #aaa; margin: 0px 20px; padding-top: 7px;">Scribbles</p>
                                </div>
                                <div class="pro-selection" onclick="window.location=\'./help/\'">
                                    <img src="res/ico/sav.png" style="width: 25px; margin: 3px 5px 3px 10px; float: left;">
                                    <p style="color: #aaa; margin: 0px 20px; padding-top: 7px;">Saved</p>
                                </div>
                                <div class="pro-selection" onclick="window.location=\'./help/\'">
                                    <img src="res/ico/com.png" style="width: 25px; margin: 3px 5px 3px 10px; float: left;">
                                    <p style="color: #aaa; margin: 0px 20px; padding-top: 7px;">Comments</p>
                                </div>
                                <div class="pro-selection" onclick="window.location=\'./help/\'">
                                    <img src="res/ico/acc.png" style="width: 25px; margin: 3px 5px 3px 10px; float: left;">
                                    <p style="color: #aaa; margin: 0px 20px; padding-top: 7px;">Followers</p>
                                </div>
                                <div class="pro-selection" onclick="window.location=\'./help/\'">
                                    <img src="res/ico/acc.png" style="width: 25px; margin: 3px 5px 3px 10px; float: left;">
                                    <p style="color: #aaa; margin: 0px 20px; padding-top: 7px;">Following</p>
                                </div>
                                <div class="pro-selection" style="margin-bottom: 10px;"  onclick="window.location=\'./statistics/\'">
                                    <img src="res/ico/stats.png" style="width: 25px; margin: 3px 5px 3px 10px; float: left;">
                                    <p style="color: #aaa; margin: 0px 20px; padding-top: 7px;">Stats</p>
                                </div><hr>

                                <div class="pro-selection" onclick="window.location=\'./settings/\'" style="margin-top: 10px;">
                                    <img src="res/ico/set.png" style="width: 25px; margin: 3px 5px 3px 10px; float: left;">
                                    <p style="color: #aaa; margin: 0px 20px; padding-top: 7px;">Settings</p>
                                </div>
                                <div class="pro-selection" onclick="window.location=\'./help/\'">
                                    <img src="res/ico/hel.png" style="width: 25px; margin: 3px 5px 3px 10px; float: left;">
                                    <p style="color: #aaa; margin: 0px 20px; padding-top: 7px;">Help</p>
                                </div>
                                <div class="pro-selection" style="margin-bottom: 10px;" onclick="window.location=\'./display/\'">
                                    <img src="res/ico/app.png" style="width: 25px; margin: 3px 5px 3px 10px; float: left;">
                                    <p style="color: #aaa; margin: 0px 20px; padding-top: 7px;">Appearance</p>
                                </div><hr>

                                <div class="pro-selection" onclick="logOut(\'./php/leave.php\');" style="margin-top: 10px;">
                                    <img src="res/ico/log.png" style="width: 25px; margin: 3px 5px 3px 10px; float: left;">
                                    <p style="color: #aaa; margin: 0px 20px; padding-top: 7px;">Log Out</p>
                                </div>
                            </div>
                        </div><button class="b1" style="float: right; margin-top: 11px;" onclick="tripto(\'./p/canvas/\')">Scribble</button>';
                        }
                    } else {
                        echo '<button class="b2" style="float: right; margin-top: 11px;" onclick = "window.location=\'./p/signup/\'">Sign Up</button>
                        <button class="b1" style="float: right; margin-top: 11px;" onclick="window.location=\'./p/signin/\'">Log In</button>';
                    }
                ?>
                
                <input type="text" id="myInput" placeholder="Search Scrilib" onkeyup="search(this)">
            </ul>
        </div>
        
        <div id="post-head-cont" class="top" style="height: 120px; max-height: 120px; position: relative; border-radius: 3px 3px 0px 0px; margin-top: 56px; padding: 80px 0px; width: 100%;">
            <img id="styImg" src="res/ico/tra.png" style="width: 100px; 100px; background-color: brown; margin: 10px; border: 1px solid #bbb; border-radius: 3px; float: left;">
            <h2 id="styName" style="font-family: Georgia; line-height: 10px; border-radius: 2px; background-color: #ddd; float: left; min-height: 20px; min-width: 150px;"></h2>
            <p id="styDes" style="color: #666; margin-top: -20px; border-radius: 2px; background-color: #ddd; min-height: 20px; min-width: 450px; max-width: 250px; float: left;"></p>

            <button id="styBtn" class="b2" style="float: left; position: absolute; top: 10px; right: 0px;">Scribble</button>
            <div id="bottom" style="position: absolute; bottom: 33px; left: 115px;">
                <p id="styPosts" style="color: #888; border-radius: 2px; background-color: #ddd; min-height: 20px; min-width: 50px; float: left; margin-left: 8px;"></p>
            </div>
        </div>
        
        <div id="view" style="position: absolute; margin-top: 20px;">
            <div id="styles" class="left" style="position: sticky; top: 75px;">
                
            </div>
            <div id="otherStys" class="right">
                
            </div>
            <div class="center" id="feed">
<!--
                <div class="tag-cont" id="tag-container">
                    <p id="style-tag" class="tag"><strong>Scribble Category: "<span id="style-tag-style" style="border-bottom: 2px solid brown;"> - </span>"</strong></p>
                    <p class="tag"><strong>72 Scribbles</strong></p>
                </div>
-->
<!--
                <div id="post-head-cont" class="top" style="height: 120px; max-height: 120px; position: relative; border-radius: 3px 3px 0px 0px;">
                    <img id="styImg" src="res/ico/tra.png" style="width: 100px; 100px; background-color: brown; margin: 10px; border: 1px solid #bbb; border-radius: 3px; float: left;">
                    <h2 id="styName" style="font-family: Georgia; line-height: 10px; border-radius: 2px; background-color: #ddd; float: left; min-height: 20px; min-width: 150px;"></h2>
                    <p id="styDes" style="color: #666; margin-top: -20px; border-radius: 2px; background-color: #ddd; min-height: 20px; min-width: 450px; max-width: 250px; float: left;"></p>
                    
                    <button id="styBtn" class="b2" style="float: left; position: absolute; top: 10px; right: 0px;">Scribble</button>
                    <div id="bottom" style="position: absolute; bottom: -7px; left: 115px;">
                        <p id="styPosts" style="color: #888; border-radius: 2px; background-color: #ddd; min-height: 20px; min-width: 50px; float: left; margin-left: 8px;"></p>
                    </div>
                </div>
-->
                
                <div id="stickyBoi" class="top" style="border-radius: 0px 0px 3px 3px; height: 44px; display: none; position: fixed; top: 60px; z-index: 5; float: left; visibility: hidden;">
                    <img id="topImg" src="res/ico/feed.png" style="width: 32px; height: 32px; background-color: brown; border: 1px solid #bbb; border-radius: 3px; margin: 5px 0px 0px 6px; float: left;">
                    <p style="float: left; font-size: 18px; margin: 8px 0px 0px 8px; line-height: 15px;"><strong id="topName">Feed | Scribbles</strong><br><span id="topNum" style="font-size: 14px; color: #888;">34 Scribbles</span></p>
                    <button id="styBtn1" class="b2" style="float: right; margin-top: 6px;">Scribble</button>
                </div>
<!--
                <div id="filter" class="top" style="border-top: 0px solid #bbb; border-radius: 0px 0px 3px 3px; margin-top: -20px;">
                    <p style="float: left; display: inline;">Recent</p>
                    <p style="float: left; display: inline;">Popular</p>
                </div>
-->
                <div id="follow" style="display: none;">
                    <span style="font-size: 12px; color: brown; letter-spacing: 1px; float: left; margin-left: 10px;"><strong>SOME SEISMIC SCRIBBLERS</strong></span>
                    <span class="close" style="float: right; margin-right: 10px; font-size: 28px; line-height: 0px; margin-top: 10px; color: brown; cursor: pointer;" onclick="this.parentElement.style.display = 'none';">&times;</span><br>
                    <div id="minCont"></div>
                </div>
                
                <div class="row">
                    <div id="c1" class="column"></div>
                    <div id="c2" class="column"></div>
                    <div id="c3" class="column"></div>
                </div>
            </div>
        </div>
    </body>
</html>