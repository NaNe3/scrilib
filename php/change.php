<?php
    $type = $_GET["typ"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "scrilib";

    if ($type == "vote") {
        session_start();
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $sql = "UPDATE scribbles SET rating=rating+" . $_GET['inc'] . " WHERE id=" . $_GET['id'];
        
        $conn->query($sql) or die($conn->error);
        
        //ADD TO USER's PROFILE
        $conn2 = new mysqli($servername, $username, $password, $dbname);
        if ($conn2->connect_error) {
            die("Connection failed: " . $conn2->connect_error);
        }
            
        if ($_GET['inc'] > 0) {
            if ($_GET['inc'] == 2) {
                $conn3 = new mysqli($servername, $username, $password, $dbname);
                $SQL = "UPDATE users SET downvoted = REPLACE(downvoted, ',e" . $_GET['id'] . "e', '') WHERE name = '" . $_SESSION['user'] . "';";
                $result = $conn3->query($SQL) or die($conn3->error);
            }
            
            $SQL = "UPDATE users SET upvoted = CONCAT(upvoted, ',e" . $_GET['id'] . "e') WHERE name = '" . $_SESSION['user'] . "';";
            $result = $conn2->query($SQL) or die($conn2->error);
            echo "upvote";
        } else {
            if ($_GET['inc'] == -2) {
                $conn3 = new mysqli($servername, $username, $password, $dbname);
                $SQL = "UPDATE users SET upvoted = REPLACE(upvoted, ',e" . $_GET['id'] . "e', '') WHERE name = '" . $_SESSION['user'] . "';";
                $result = $conn3->query($SQL) or die($conn3->error);
            }
            $SQL = "UPDATE users SET downvoted = CONCAT(downvoted, ',e" . $_GET['id'] . "e') WHERE name = '" . $_SESSION['user'] . "';";
            $result = $conn2->query($SQL) or die($conn2->error);
            echo "downvote";
        }
    } else if ($type == "view") {
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $sql = "UPDATE scribbles SET views=views+1 WHERE id=" . $_GET['id'];
        
        $conn->query($sql) or die($conn->error);
    } else if ($type == "fol") {
        session_start();
        echo $_GET['per'];
        echo $_SESSION['user'];
        if ($_GET['per'] != $_SESSION['user']) {
            $conn = new mysqli($servername, $username, $password, $dbname);
            $sql = "SELECT * FROM users WHERE name='" . $_GET['per'] . "';";
            $result = $conn->query($sql) or die($conn->error);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()){
                    if (strpos($row['followers'], $_SESSION['user']) == false) {
                        $follow = true;
                    } else {
                        $follow = false;
                    }
                }
            } else {
                $follow = false;
            }
        } else {
            $follow = false;
        }
        
        if ($follow == true) {
            $conn = new mysqli($servername, $username, $password, $dbname);
            $sql = "UPDATE users SET following= CONCAT(following, '," . $_GET["per"] . "') WHERE name = '" . $_SESSION['user'] . "';";
            $result = $conn->query($sql) or die($conn->error);
        
            $conn = new mysqli($servername, $username, $password, $dbname);
            $SQL = "UPDATE users SET followers = CONCAT(followers, '," . $_SESSION['user'] . "') WHERE name = '" . $_GET['per'] . "';";
            $result = $conn->query($SQL) or die($conn->error);
        }
        
    } else if ($type == "unfol") {
        session_start();
        
        //FIRST GET USER's new following string
        $conn = new mysqli($servername, $username, $password, $dbname);
        $sql = "SELECT following FROM users WHERE name = '" . $_SESSION['user'] . "'";
        $result = $conn->query($sql) or die($conn->error);
        while($row = $result->fetch_assoc()){
            $NewFol = str_replace("," . $_GET['per'], "", $row['following']);
        }
        //THEN PUSH UPDATED STRING INTO ROW
        $conn = new mysqli($servername, $username, $password, $dbname);
        $sql = "UPDATE users SET following='" . $NewFol . "' WHERE name = '" . $_SESSION['user'] . "';";
        $result = $conn->query($sql) or die($conn->error);

        //NOW YOU DO THE SAME BUT FOR THE FOLLOWERS FOR THE odder
        $conn = new mysqli($servername, $username, $password, $dbname);
        $sql = "SELECT followers FROM users WHERE name = '" . $_GET['per'] . "'";
        $result = $conn->query($sql) or die($conn->error);
        while($row = $result->fetch_assoc()){
            $NewFng = str_replace("," . $_SESSION['user'], "", $row['followers']);
        }
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        $sql = "UPDATE users SET followers='" . $NewFng . "' WHERE name = '" . $_GET['per'] . "';";
        $result = $conn->query($sql) or die($conn->error);
    } else if ($type == "sav") {
        session_start();
        $conn = new mysqli($servername, $username, $password, $dbname);
        $SQL = "UPDATE users SET saves = CONCAT(saves, ',e" . $_GET['id'] . "e') WHERE name = '" . $_SESSION['user'] . "';";
        $result = $conn->query($SQL) or die($conn->error);
        echo " I DONT DID'Dt IT";
    } else if ($type == "unsav") {
        session_start();
        $conn = new mysqli($servername, $username, $password, $dbname);
        $SQL = "UPDATE users SET saves = REPLACE(saves, ',e" . $_GET['id'] . "e', '') WHERE name = '" . $_SESSION['user'] . "';";
        $result = $conn->query($SQL) or die($conn->error);
        echo " I DONT DID'Dt IT";
    }
?>