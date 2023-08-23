<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Scrilib | Your New Home</title>
        <meta charset="utf-8">
        <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1" />
        
        <link rel="icon" type="image/png" href="../res/ast/fav.ico">
        <link href="../css/style.css" rel="stylesheet" type="text/css">
        <link href="../css/nav.css" rel="stylesheet" type="text/css">
        <link href="css/config.css" rel="stylesheet" type="text/css">
        <script src="../js/script.js"></script>
        <script src="../js/ajax.min.js"></script>
        <script src="../js/config.js"></script>
        <script>
            <?php
                if (isset($_SESSION['user']) != true) {
                    echo 'window.location = "../signin/"';
                }
            ?>
            
            var user = "<?php echo $_SESSION['user']; ?>";
        </script>
    </head>
    <body>
<!--        <h1 class="title" style="margin-bottom: -50px;" onclick="window.location='index.php'"><span style="color: brown">Scrilib</span></h1>-->
        <div id="nav">
            <ul>
                <p class="title" onclick="window.location = '../'"><strong>Scrilib</strong></p>
                <li class="u"><a href="../">Hearth</a></li>
                <li class="u"><a href="../archive">Archive</a></li>
                <?php
                    if (isset($_SESSION['auth'])) {
                        if ($_SESSION['auth'] == false) {
                            echo '<button class="b2" style="float: right; margin-top: 11px;" onclick = "window.location=\'./p/signup/\'">Sign Up</button>
                            <button class="b1" style="float: right; margin-top: 11px;" onclick="window.location=\'./p/signin/\'">Log In</button>';
                        } else {
                            echo '<div id="pro-cont" style="position: relative;">
                            <img id="pro-btn" src="../res/usr/' . $_SESSION['src'] . '" style="float: right; height: 32px; width: 32px; border: 1px solid #bbb; border-radius: 3px; margin-top: 10px; margin-left: 10px; cursor: pointer;">
                            <div id="tri-cont" class="triangle-up" style="opacity: 0;"></div>
                            <div id="pro-drop" style="opacity: 0;">
                                <img src="../res/usr/' . $_SESSION['src'] . '" style="width: 65px; border-radius: 300px; margin: 7px 7px; float: left; background-color: white;">
                                <div class="pro-selection" style="border-bottom: 1px solid #ddd; height: 65px;" onclick="window.location=\'../user/' . $_SESSION['user'] . '/\';">
                                    <p style="color: brown; font-size: 20px; margin: 0px 0px 0px 20px; padding-top: 15px;">' . $_SESSION['fname'] . ' ' . $_SESSION['lname'] . '</p>
                                    <p style="font-size: 12px; color: #bbb; margin: 0px 0px 0px 20px;">' . $_SESSION['user'] . '</p>
                                </div>
                                <div class="pro-selection" style="margin-top: 15px;"  onclick="window.location=\'../gossamer/\'">
                                    <img src="../res/ico/web.png" style="width: 25px; margin: 3px 5px 3px 10px; float: left;">
                                    <p style="color: #aaa; margin: 0px 20px; padding-top: 7px;">Gossamer</p>
                                </div>
                                <div class="pro-selection" style="margin-bottom: 10px;"  onclick="window.location=\'../statistics/\'">
                                    <img src="../res/ico/stats.png" style="width: 25px; margin: 3px 5px 3px 10px; float: left;">
                                    <p style="color: #aaa; margin: 0px 20px; padding-top: 7px;">Stats</p>
                                </div><hr>

                                <div class="pro-selection" onclick="window.location=\'../settings/\'" style="margin-top: 10px;">
                                    <img src="../res/ico/set.png" style="width: 25px; margin: 3px 5px 3px 10px; float: left;">
                                    <p style="color: #aaa; margin: 0px 20px; padding-top: 7px;">Settings</p>
                                </div>
                                <div class="pro-selection" onclick="window.location=\'../help/\'">
                                    <img src="../res/ico/hel.png" style="width: 25px; margin: 3px 5px 3px 10px; float: left;">
                                    <p style="color: #aaa; margin: 0px 20px; padding-top: 7px;">Help</p>
                                </div>
                                <div class="pro-selection" style="margin-bottom: 10px;" onclick="window.location=\'../display/\'">
                                    <img src="../res/ico/app.png" style="width: 25px; margin: 3px 5px 3px 10px; float: left;">
                                    <p style="color: #aaa; margin: 0px 20px; padding-top: 7px;">Appearance</p>
                                </div><hr>

                                <div class="pro-selection" onclick="logOut(\'../php/leave.php\');" style="margin-top: 10px;">
                                    <img src="../res/ico/log.png" style="width: 25px; margin: 3px 5px 3px 10px; float: left;">
                                    <p style="color: #aaa; margin: 0px 20px; padding-top: 7px;">Log Out</p>
                                </div>
                            </div>
                        </div><button class="b1" style="float: right; margin-top: 11px;" onclick="tripto(\'../p/canvas/\')">Scribble</button>';
                        }
                    } else {
                        echo '<button class="b2" style="float: right; margin-top: 11px;" onclick = "window.location=\'./p/signup/\'">Sign Up</button>
                        <button class="b1" style="float: right; margin-top: 11px;" onclick="window.location=\'./p/signin/\'">Log In</button>';
                    }
                ?>
                <input type="text" id="myInput" placeholder="Search Scrilib" onkeyup="search(this)">
            </ul>
        </div>
        <div id="view" style="position: absolute;">
            <div id="styles" class="left">
                <div id="cols" class="style">
                    <div class="imgDiv">
                        <img src="../res/ico/feed.png">
                    </div>
                    <p>General</p>
                </div>
                <div id="cols" class="style">
                    <div class="imgDiv">
                        <img src="../res/ico/feed.png">
                    </div>
                    <p>Account</p>
                </div>
                <div id="cols" class="style">
                    <div class="imgDiv">
                        <img src="../res/ico/feed.png">
                    </div>
                    <p>Privacy / Security</p>
                </div>
                <div id="cols" class="style">
                    <div class="imgDiv">
                        <img src="../res/ico/feed.png">
                    </div>
                    <p>Premium</p>
                </div>
            </div>
            <div id="otherStys" class="right">
                
            </div>
            <div id="feed" class="center" style="border: 1px solid brown; height: 200px; background-color: #fff; border-radius: 3px;">
                
            </div>
        </div>
    </body>
</html>