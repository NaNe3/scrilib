<?php
    session_start();
    if (isset($_SESSION['auth'])) {
        echo "<script> var auth = true; var per = '" . $_SESSION['user'] . "';</script>";
    } else {
        echo "<script> var auth = false; var per = 'EL!'</script>";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1">
    </head>
    <body>
        <div id="nav" style="box-shadow: 0 3px 2px -2px rgba(200,200,200,0); border: 0;">
            <ul style="width: 95%;">
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
        
        <div class="top" style="height: 120px; max-height: 120px; width: 100%; border-radius: 3px 3px 0px 0px; margin-top: 50px; position: relative; padding-bottom: 40px; padding-top: 40px; border: 0; box-shadow: 0 3px 2px -2px rgba(200,200,200,0.2);">
            <button id="usrBtn" class="b2" style="position: absolute; top: 40px; right: 95px; display: none;" onclick="window.location='../../p/canvas/'">Scribble</button>
            <button id="usrFng" class="b2" style="position: absolute; top: 40px; right: 95px; width: 100px; display: none;"></button>
            <button id="usrFol" class="b1" style="position: absolute; top: 40px; right: 98px; width: 100px; display: none;">Follow</button>

            <img id="usrImg" src="../../res/ast/fav.ico" style="width: 100px; height: 100px; margin: 10px; border: 1px solid brown; border-radius: 3px; float: left; margin-left: 100px;">
            <h2 id="usrName" style="font-family: Georgia; line-height: 10px; border-radius: 2px; background-color: #ddd; float: left; min-height: 20px; min-width: 150px;"></h2>
            <p id="usrDes" style="color: #666; margin-top: 40px; border-radius: 2px; background-color: #ddd; min-height: 20px; min-width: 450px; max-width: 450px; position:absolute; left: 212px;"></p>

            <div id="bottom" style="position: absolute; bottom: -7px; left: 205px; width: 460px; border-radius: 2px;">
                <div style="width: 150px; float: left; margin-left: 8px;">
                    <img src="../../res/ico/acc.png" style="width: 20px; float: left; background-color: #ddd; border: 1px solid #bbb; border-radius: 3px; bottom: 55px; position: absolute; margin-left: 8px; margin-left: 0px;">
                    <p id="usrFollowers" style="float: left; color: #888; margin-left: 26px;">Followers: 000</p>
                </div>

                <div style="width: 150px; margin: auto;">
                    <img src="../../res/ico/acc.png" style="width: 20px; float: left; background-color: #ddd; border: 1px solid #bbb; border-radius: 3px; bottom: 55px; position: absolute; margin-left: 0px;">
                    <p id="usrFollowing" style="float: left; color: #888; margin-left: 26px; margin-bottom: 55px;">Following: 000</p>
                </div>

                <div style="width: 150px; float: right;">
                    <img src="../../res/ico/scr.png" style="width: 20px; float: left; background-color: #ddd; border: 1px solid #bbb; border-radius: 3px; bottom: 55px; position: absolute; margin-left: 0px;">
                    <p id="usrPosts" style="float: left; color: #888; margin-left: 26px;">Scribbles: 000</p>
                </div>
            </div>
        </div>
        
        <div id="view" style="position: absolute; margin-top: 20px;">
            <div id="styles" class="left" style="position: sticky; top: 75px;">
                <div id="cols" class="style">
                    <div class="imgDiv">
                        <img src="../../res/ico/feed.png">
                    </div>
                    <p>Portfolio</p>
                </div>
                <hr>
                <div id="scrs" class="style">
                    <div class="imgDiv">
                        <img src="../../res/ico/scr.png">
                    </div>
                    <p>Scribbles</p>
                </div>
                <div id="coms" class="style">
                    <div class="imgDiv">
                        <img src="../../res/ico/com.png">
                    </div>
                    <p>Comments</p>
                </div>
                <div id="savs" class="style">
                    <div class="imgDiv">
                        <img src="../../res/ico/sav.png">
                    </div>
                    <p>Saved</p>
                </div>
                <div id="ups" class="style">
                    <div class="imgDiv">
                        <img src="../../res/ico/ups.png">
                    </div>
                    <p>Upvoted</p>
                </div>
                <div id="downs" class="style">
                    <div class="imgDiv">
                        <img src="../../res/ico/downs.png">
                    </div>
                    <p>Downvoted</p>
                </div>
                <hr>
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
            </div>
            <div class="right" style="position: sticky; top: 75px;">
<!--
                <div id="profileStuff" style="display: none;">
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
                    <div id="log" class="style" style="margin-top: -10px;">
                        <div class="imgDiv">
                            <img src="../../res/ico/log.png">
                        </div>
                        <p>Log Out</p>
                    </div>
                </div>
-->
            </div>
            <div class="center" id="feed">
<!--                HERER IS PLACE-->
                <div id="folSelection" class="top" style="display: none;">
                    <p id="scrsD" class="port" style="border-bottom: 2px solid brown;" onclick="port(this, 'norm')">Scribbles</p>
                    <p id="comsD" class="port" onclick="port(this, 'norm')">Comments</p>
                    <p id="savsD" class="port" onclick="port(this, 'norm')">Saved</p>
                </div>
                
                <div id="stickyBoi" class="top" style="border-radius: 0px 0px 3px 3px; height: 44px; position: fixed; top: 60px; z-index: 5; float: left; display: none;">
                    <img id="topImg" src="../../res/ast/fav.ico" style="width: 32px; height: 32px; background-color: #fff; border: 1px solid brown; border-radius: 3px; margin: 5px 0px 0px 6px; float: left;">
                    
                    <p style="float: left; font-size: 18px; margin: 8px 0px 0px 8px; line-height: 15px;"><strong id="topName"></strong><br><span id="topFol" style="font-size: 14px; color: #888;"></span><span id="topFng" style="font-size: 14px; color: #888; padding-left: 12px; margin-left: 12px; border-left: 1px solid #bbb;"></span><span id="topScr" style="font-size: 14px; color: #888; padding-left: 12px; margin-left: 12px; border-left: 1px solid #bbb;"></span></p>
                    
                    <button id="styBtn1" class="b2" style="float: right; margin-top: 6px;">Beam Me Up</button>
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
                <div id="comD" class="row" style="display: none;">
<!--
                    <div class="portCom">
                        <div class="portImg">
                            <img src="../../scribble/45/img20190529182913.png">
                        </div>
                        <div class="comBar">
                            <a href="." class="subText"><strong>Author's Name</strong></a>
                            <p class="subText">123 pts</p>
                            <p class="subText">May 13</p>
                        </div>
                        <p> I HONESTLY BELIEVE THAT KIDS ARE STUPID CRAP HEADS WHO ARE MEENI WEENIES</p>
                    </div>
-->
                </div>
                <div id="savD" class="row" style="display: none;">
                    <div id="colsD1" class="row" style="margin-top: 0px; display: block;">
                        <div id="c4" class="column"></div>
                        <div id="c5" class="column"></div>
                        <div id="c6" class="column"></div>
                    </div>
                </div>
                <div id="upsD" class="row" style="display: none;">
                    <div id="colsD2" class="row" style="margin-top: 0px; display: block;">
                        <div id="c7" class="column"></div>
                        <div id="c8" class="column"></div>
                        <div id="c9" class="column"></div>
                    </div>
                </div>
                <div id="downsD" class="row" style="display: none;">
                    <div id="colsD3" class="row" style="margin-top: 0px; display: block;">
                        <div id="c10" class="column"></div>
                        <div id="c11" class="column"></div>
                        <div id="c12" class="column"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="../../js/script.js"></script>
        <script src="../../js/ajax.min.js"></script>
        <script src="../../js/folio.js"></script>
    </body>
</html>