<?php
    
    $query = $_GET['q'];
    $type = $_GET['typ'];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "scrilib";

    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($type == "users") {
        $sql = "SELECT * FROM users WHERE name LIKE '%" . $query . "%' ORDER BY id DESC LIMIT 20 OFFSET 0";
        $result = $conn->query($sql);
        $arr = array();

        while($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }

        echo json_encode($arr);
    } else if ($type == "comments") {
        if($_GET['search'] == "*") {
            $search = "comment LIKE '%" . $query . "%' OR author LIKE '%" . $query . "%'";
        } else if ($_GET['search'] == "comment" || $_GET['search'] == "author") {
            $search = $_GET['search'] . " LIKE '%" . $query . "%'";
        }
        
        if ($_GET['display'] == "RAND") {
            $order = "RAND()";
            $disp = "";
        } else {
            $order = $_GET['order'];
            $disp = $_GET['display'];
        }
        
        $sql = "SELECT * FROM comments WHERE " . $search . " ORDER BY " . $order . " " . $disp . " LIMIT 20 OFFSET " . $_GET['off'];
        $result = $conn->query($sql);
        $arr = array();

        while($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }

        echo json_encode($arr);
    } else if ($type == "scribbles") {
        if($_GET['search'] == "*") {
            $search = "name LIKE '%" . $query . "%' OR author LIKE '%" . $query . "%'";
        } else if ($_GET['search'] == "name" || $_GET['search'] == "author") {
            $search = $_GET['search'] . " LIKE '%" . $query . "%'";
        }
        
        if ($_GET['display'] == "RAND") {
            $order = "RAND()";
            $disp = "";
        } else {
            $order = $_GET['order'];
            $disp = $_GET['display'];
        }
        
        $sql = "SELECT * FROM scribbles WHERE " . $search . " ORDER BY " . $order . " " . $disp . " LIMIT 20 OFFSET " . $_GET['off'];
        $result = $conn->query($sql);
        $arr = array();

        while($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }

        echo json_encode($arr);
    }

?>