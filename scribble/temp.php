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
        <meta charset="utf-8">
        <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1" />
        
<!--
        <link href="../../css/style.css" rel="stylesheet" type="text/css">
        <link href="../../css/nav.css" rel="stylesheet" type="text/css">
        <link href="../../css/scribble.css" rel="stylesheet" type="text/css">
-->
        <script>
            if (auth == true) {
                var user = "<?php
                    if (isset($_SESSION['user'])) {
                        echo $_SESSION['user'];
                    } else {
                        echo "EL!";
                    }
                ?>";  
            }
        </script>
    </head>
    <body>
<!--        <h1 class="title" style="margin-bottom: -50px;" onclick="window.location='index.php'"><span style="color: brown">Scrilib</span></h1>-->
        <div id="nav" style="position: absolute;">
            <ul>
                <p class="title" onclick="window.location = '../../'"><strong>Scrilib</strong></p>
                <li class="u"><a class="active" href="../../">Hearth</a></li>
                <li class="u"><a href="../../archive">Archive</a></li>
                <?php
                    if (isset($_SESSION['auth'])) {
                        if ($_SESSION['auth'] == false) {
                            echo '<button class="b2" style="float: right; margin-top: 11px;" onclick = "window.location=\'../../p/signup/\'">Sign Up</button>
                            <button class="b1" style="float: right; margin-top: 11px;" onclick="window.location=\'../../p/signin/\'">Log In</button>';
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
                        echo '<button class="b2" style="float: right; margin-top: 11px;" onclick = "window.location=\'../../p/signup/\'">Sign Up</button>
                        <button class="b1" style="float: right; margin-top: 11px;" onclick="window.location=\'../../p/signin/\'">Log In</button>';
                    }
                ?>
                <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search Scrilib">
            </ul>
        </div>
        <div id="scriView" style="position: absolute; top: 100px;">
            <div class="right" style="float: right; overflow: hidden; border-radius: 3px;">
                <div style="height: 52px; width: 280px; background-color: #eee; margin-top: 0px;">
                    <h3 id="anon" style="margin: 0; padding: 8px 9px; text-align: left; font-size: 16px;">Spotlight - <a id="authSpot" href="#"></a></h3>
                    <p style="font-size: 11px; color: #999; text-align: left; line-height: 0px; margin-top: 0px; margin-left: 9px">Sort By Newest Scribbles</p>
                </div>
                <div id="scribs"></div>
                <div style="width: 278px; height: 240px; background-color: #fff; border-radius: 3px; margin-top: 20px; border: 1px solid brown;">
                    <p style="font-size: 12px; color: #999; margin: 10px 0px 0px 10px;">PROMOTIONAL</p>
                </div>
            </div>
            
            <div class="imgBar" style="z-index: 100;">
                <button id="next" class="b1" style="float: right; margin: 8px 20px 0px 5px;">Next Post</button>
                <button id="back" class="b2" style="float: right; margin: 8px 0px;">Back</button>
                
<!--
                <div id="vote" style="margin-right: 50px;">
                    <img id="img1" src="../../res/ico/vote.png" onclick="upvote()" style="float: left;">
                    <p id="scrRating" style="float: left; font-size: 14px; line-height: 0px; margin: 12px; margin-left: 20px; color: #999; margin-top: 13px;">0</p>
                    <img id="img2" src="../../res/ico/vote.png" onclick="downvote()" style="float: left;">
                </div>
-->
                
                <h2 id="scrTitle" style="font-size: 24px; margin-left: 20px; margin-top: 15px; line-height: 0px; margin-bottom: 23px;">Scribble Title</h2>
                <p style="margin-top: 0px; margin-left: 20px; font-size: 13px; line-height: 0px;">by <a id="scrAuthor" href="../../p/folio/">Auth</a><span id="scrTime" style="margin-left: 40px;">May 7</span></p>
            </div>
            <div class="imgView">
                <img id="scrImg">
            </div>
            <div class="imgBar" style="border-radius: 0px 0px 3px 3px; margin-top: -2px;">
                <button id="savBtn" class="b1" style="float: right; margin: 8px 20px; display: none;">Save</button>
                <button id="unsavBtn" class="b2" style="float: right; margin: 8px 20px; display: none;">UnSave</button>
                
                <div id="vote" style="margin-right: 50px; margin-top: 15px;">
                    <img id="img1" src="../../res/ico/vote.png" onclick="upvote()" style="float: left;">
                    <p id="scrRating" style="float: left; font-size: 14px; line-height: 0px; margin: 12px; margin-left: 20px; color: #999; margin-top: 13px; width:30px; text-align: center;">0</p>
                    <img id="img2" src="../../res/ico/vote.png" onclick="downvote()" style="float: left;">
                </div>
            </div>
            
            <div id="comment">
                <p id="mainComP" style="font-size: 12px; color: #666; position: absolute; top: 0px; right: 10px;">120</p>
                <textarea for="mainComForm" name="mainCom" id="mainCom" placeholder="Speak Your Dadgum Mind" oninput="AutoGrowTextArea(this); ta('mainCom', 'mainComP', 'mainComB')"></textarea>
                <a href="#" style="float: left; margin: 8px 18px;">Refer to the posting guide</a>
                <button id="mainComB" class="b2" style="margin-bottom: 7px; float: right;">Post</button>
            </div>
            
            <div id="comments">
                <div id="cHead">
                    <p id="cNum">0 comments</p>
                </div>
<!--
                <div class="com">
                    <div class="comBar">
                        <a href="#" style="font-size: 12px; margin-right: 20px; float: left;">Author's Name</a>
                        <p class="subText">123 points</p>
                        <p class="subText">May 13</p>
                    </div>
                    <p>What a lovely post you've got ther</p>
                    <div class="comBar">
                        <p class="subTextA">Reply</p>
                        <p class="subTextA">Share</p>
                        <p class="subTextA">Save</p>
                    </div>
                </div>
-->
<!--
                <div class="com">
                    <div class="comCont">
                        <div class="comBar">
                            <a href="#" class="subText"><strong>Author's Name</strong></a>
                            <p class="subText">123 pts</p>
                            <p class="subText">May 13</p>
                        </div>
                        <p style="margin-bottom: 10px;">No Stenosis</p>
                    </div>
                    <div class="com" style="padding-left: 40px; margin-top: 10px;">
                        <div class="comMent">
                            <p style="font-size: 12px; color: #666; position: absolute; bottom: 35px; right: 10px;">120</p>
                            <span class="close">&times;</span>
                            <textarea placeholder="This comment is ..."></textarea>
                            <a href="#" style="float: left; margin: 8px 18px;">Refer to the posting guide</a>
                            <button class="b2" style="margin-bottom: 7px; float: right;">Post</button>
                        </div>
                    </div>
                </div>
-->

                
            </div>
            
        </div>
        <script src="../../js/ajax.min.js"></script>
        <script src="../../js/script.js"></script>
        <script src="../../js/scribble.js"></script>
    </body>
</html>