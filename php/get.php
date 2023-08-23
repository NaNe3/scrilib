<?php
    $type = $_GET["typ"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "scrilib";
    

    //AVERAGE RATING

    function getAvg() {
        $conn = new mysqli("localhost", "root", "", "scrilib");
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $sql = "SELECT AVG(rating) FROM scribbles";
        
        $result = $conn->query($sql) or die($conn->error);
        return implode($result->fetch_assoc());
    }
    
    //REQUESTED INFORMATINO TREE
    if ($type == 'email') {    
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $sql = "SELECT * FROM users WHERE email = '" . $_GET['sub'] . "'";

        $arr = array();
        $result = $conn->query($sql) or die($conn->error);
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        
        if (count($arr) == 0) {
           echo false;
        } else { echo true; }
    } else if ($type == 'usr') {
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $sql = "SELECT * FROM users WHERE name = '" . $_GET['sub'] . "'";

        $arr = array();
        $result = $conn->query($sql) or die($conn->error);
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        
        if (count($arr) == 0) {
           echo false;
        } else { 
            echo true; 
        }
    } else if ($type == 'acc') {
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $sql = "SELECT * FROM users WHERE name = '" . $_GET['name'] . "' AND password = '" . $_GET['pass'] . "' OR email = '" . $_GET['name'] . "' AND password = '" . $_GET['pass'] . "'";
        
        $arr = array();
        $result = $conn->query($sql) or die($conn->error);
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        
        if (count($arr) == 0) {
            echo "false";
        } else { echo "true"; }
    } else if ($type == 'scr') {
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        //WORKING SQL: SELECT * FROM `posts` ORDER BY `no` DESC LIMIT 1 OFFSET 1
        if ($_GET['sty'] == "*") {
            $sql = "SELECT * FROM scribbles ORDER BY id DESC LIMIT 20 OFFSET " . $_GET['off'];
        } else if ($_GET['sty'] == "Popular") {
            $avg = getAvg();
            
            $sql = "SELECT * FROM scribbles WHERE rating > " . $avg . " ORDER BY id DESC LIMIT 20 OFFSET " . $_GET['off'];
        } else if ($_GET['sty'] == "Feed") {
            //$sql = "SELECT * FROM users WHERE following LIKE '%" . $_GET['usr'] . "' ORDER BY id DESC LIMIT 40 OFFSET " . $_GET['off'];
            $sql = "SELECT * FROM scribbles ORDER BY id DESC LIMIT 300000 OFFSET " . $_GET['off'];// LIMIT 20 OFFSET " . $_GET['off'];
        } else {
            $sql = "SELECT * FROM scribbles WHERE style = '" . $_GET["sty"] . "' ORDER BY id DESC LIMIT 20 OFFSET " . $_GET['off'];
        }
        $result = $conn->query($sql);
        $arr = array();

        if ($_GET['sty'] == "Feed") {
            $scribbles = 0;
            while($row = $result->fetch_assoc()) {
                if (strpos($_GET["usr"], $row['author'])) {
                    $arr[] = $row;   
                    $scribbles += 1;
                }
                if ($scribbles == 20) {
                    break;
                }
            }
            //echo $_GET['usr'];
        } else {
            while($row = $result->fetch_assoc()) {
                $arr[] = $row;
            }
        }

        echo json_encode($arr);
    } else  if ($type == "sty") {
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        //WORKING SQL: SELECT * FROM `posts` ORDER BY `no` DESC LIMIT 1 OFFSET 1
        $sql = "SELECT * FROM styles";
        $result = $conn->query($sql);
        $arr = array();

        while($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }

        echo json_encode($arr);
    } else if ($type == "scrAcc") {
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $sql = "SELECT * FROM scribbles WHERE author = '" . $_GET["usr"] . "' ORDER BY id DESC LIMIT 20 OFFSET " . $_GET['off'];
        $result = $conn->query($sql);
        $arr = array();

        while($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }

        echo json_encode($arr);
    } else if ($type == "usrInfo") {
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        $sql = "SELECT * FROM users WHERE name = '" . $_GET['usr'] . "'";
        $arr = array();
        $result = $conn->query($sql) or die($conn->error);
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        
        echo json_encode($arr);
    } else if ($type == "followers") {
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        $sql = "SELECT * FROM users WHERE followers LIKE '%" . $_GET['usr'] . "%' ORDER BY id DESC LIMIT 40 OFFSET " . $_GET['off'];
        $arr = array();
        $result = $conn->query($sql) or die($conn->error);
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        
        echo json_encode($arr);
    } else if ($type == "following") {
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        $sql = "SELECT * FROM users WHERE following LIKE '%" . $_GET['usr'] . "%' ORDER BY id DESC LIMIT 40 OFFSET " . $_GET['off'];
        $arr = array();
        $result = $conn->query($sql) or die($conn->error);
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        
        echo json_encode($arr);
    } else if ($type == "usrAttr") {
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        $sql = "SELECT " . $_GET['attr'] . " FROM users WHERE name='" . $_GET['usr'] . "'";
        
        $result = $conn->query($sql) or die($conn->error);
        while ($row = $result->fetch_assoc()) {
            echo $row[$_GET['attr']];
        }
    } else if ($type == "sing") {
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        $sql = "SELECT * FROM scribbles WHERE id=" . $_GET['id'];
        
        $result = $conn->query($sql) or die($conn->error);
        while ($row = $result->fetch_assoc()) {
            echo json_encode($row);
        }
    } else if ($type == "coms") {
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        $sql = "SELECT * FROM comments WHERE no=" . $_GET['post'];
        $result = $conn->query($sql) or die($conn->error);
        
        $arr = array();
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        
        echo json_encode($arr);
    } else if ($type == "usrCom") {
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        $sql = "SELECT * FROM comments WHERE author='" . $_GET['usr'] . "' ORDER BY id DESC LIMIT 30 OFFSET " . $_GET['off'];
        $result = $conn->query($sql) or die($conn->error);
        
        $arr = array();
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        
        echo json_encode($arr);
    } else if ($type == "pstNum") {
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        $sql = "SELECT COUNT(*) FROM " . $_GET['base'];
        $result = $conn->query($sql) or die($conn->error);
        
        while ($row = $result->fetch_assoc()) {
            echo $row['COUNT(*)'];
        }
    } else if ($type == "hotCom") {
        session_start();
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        $sql = "SELECT * FROM users WHERE scribbles > 0 ORDER BY RAND() LIMIT 30";
        $result = $conn->query($sql) or die($conn->error);
        
        $arr = array();
        while ($row = $result->fetch_assoc()) {
            if ($_SESSION['user'] != $row['name'] and strpos($row['followers'], $_SESSION['user']) != true) {
                $arr[] = $row;
            }
        }
        
        echo json_encode($arr);
    } else if ($type == "seq") {
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        $sql = "SELECT COUNT(*) FROM scribbles";
        $result = $conn->query($sql) or die($conn->error);
        
        $arr = array();
        while ($row = $result->fetch_assoc()) {
            $offset = $row['COUNT(*)'] - $_GET['off'];
        }
        
        $conn2 = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn2->connect_error) {
            die("Connection failed: " . $conn2->connect_error);
        } 
        $sql = "SELECT * FROM scribbles ORDER BY id DESC LIMIT 20 OFFSET " . $offset;
        $result = $conn2->query($sql) or die($conn2->error);
        
        $arr = array();
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        
        echo json_encode($arr);
    } else if ($type == "archive") {
        $conn2 = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn2->connect_error) {
            die("Connection failed: " . $conn2->connect_error);
        } 
        $sql = "SELECT * FROM " . $_GET['sub'] . " ORDER BY id " . $_GET['order'] . " LIMIT " . $_GET['limit'] . " OFFSET " . ($_GET['page']*$_GET['limit']);
        $result = $conn2->query($sql) or die($conn2->error);
        
        $arr = array();
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        
        echo json_encode($arr);
    } else if ($type == "proPic") {
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        $sql = "SELECT img FROM users WHERE name='" . $_GET['usr'] . "'";
        $result = $conn->query($sql) or die($conn->error);
        echo implode($result->fetch_assoc());
    }
?>