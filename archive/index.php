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
        <link href="../css/archive.css" rel="stylesheet" type="text/css">
        <script src="../js/script.js"></script>
        <script src="../js/ajax.min.js"></script>
        <script src="../js/archive.js"></script>
        <script>
            var page = <?php if (isset($_GET['pg'])) { echo $_GET['pg']; } else { echo -1; } ?>;
            
            var user = "<?php if (isset($_SESSION['user'])) { echo $_SESSION['user']; } else { echo "EL!"; } ?>";
        </script>
    </head>
    <body>
<!--        <h1 class="title" style="margin-bottom: -50px;" onclick="window.location='index.php'"><span style="color: brown">Scrilib</span></h1>-->
        <div id="nav">
            <ul>
                <p class="title" onclick="window.location = '../'"><strong>Scrilib</strong></p>
                <li class="u"><a href="../">Hearth</a></li>
                <li class="s"><a href="../archive">Archive</a></li>
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
            <div id="styles" class="left" style="margin-top: 0px; position: static;">
                <div class="archive-cat-cont" style="margin-bottom: 10px;">
                    <p class="search-head">Content</p>
                    <p id="scribbles" class="search-opt">Scribbles</p>
                    <p id="users" class="search-opt">Artists</p>
                </div><hr style="margin-bottom: 10px;">
                
                <div class="archive-cat-cont" style="margin-bottom: 10px;">
                    <p class="search-head">Display By</p>
                    <p id="DESC" class="search-opt">Newest</p>
                    <p id="ASC" class="search-opt">Oldest</p>
                </div>
                
<!--
                <div class="archive-cat-cont">
                    <p class="search-head">Time</p>
                    <p id="None" class="search-opt">None</p>
                    <p id="1h" class="search-opt">1 Hour</p>
                    <p id="1w" class="search-opt">1 Week</p>
                    <p id="1m" class="search-opt">1 Month</p>
                    <p id="1y" class="search-opt">1 Year</p>
                </div>
-->
                
                <div class="archive-cat-cont">
                    <p class="search-head">Entry Limit</p>
                    <p id="25" class="search-opt">25</p>
                    <p id="50" class="search-opt">50</p>
                    <p id="100" class="search-opt">100</p>
                    <p id="250" class="search-opt">250</p>
                </div>
            </div>
            
            <div id="archive-container">
                <table id="tbl-styles"></table>
                <table id="tbl-users"></table>
            </div>
        </div>
    </body>
</html>