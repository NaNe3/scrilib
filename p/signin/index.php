<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Scrilib | Access Your Account</title>
        <meta charset="utf-8">
        <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1" />
        
        <link href="../../css/style.css" rel="stylesheet" type="text/css">
        <link href="../../css/access.css" rel="stylesheet" type="text/css">
        <script>
            var type = "in";
        </script>
        <script src="../../js/access.js"></script>
        <script src="../../js/ajax.min.js"></script>
    </head>
    <body>
        <div id="portal">
            <p class="title" style="color: brown; text-align: center; font-size: 28px; cursor: pointer;" onclick="window.location='../../';"><strong style="border-bottom: 1px solid brown; padding: 10px 75px;">Scrilib</strong></p>
            <form style="width: 100%;" method="post" action="../../php/access.php?mod=in">
                <label style="color: red; display: none; margin-left: 20px;"></label>
                <input class="val" id="user" name="user" placeholder="Email or Username" style="margin: 10px 20px; width: 325px;">
                <input class="val" id="pass" name="pass" type="password" placeholder="Password" style="margin: 10px 20px; width: 325px;"><br><br>
                
                <input id="signin" type="submit" style="display: none;">
            </form>
            <button id="subBut" class="b1" style="margin-left: 20px;" onclick="validAcc()">Sign In</button> or <a href="../signup/">Register</a> a non-existing account<br><br>
        </div>
    </body>
</html>