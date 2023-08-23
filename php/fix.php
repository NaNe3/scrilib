<?php
    $type = $_GET['typ'];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "scrilib";
    
    echo "GOT HERER";
    if ($type == "accs") {
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $sql = "SELECT * FROM users";

        $result = $conn->query($sql) or die($conn->error);
        while ($row = $result->fetch_assoc()) {
            if (!file_exists('../user/' . $row['name'])) {
                mkdir('../user/' . $row['name'], 0777, true);
            }
            $srcfile = '../user/redir.php';
            $destfile = '../user/' . $row['name'] . "/index.php";
            copy($srcfile, $destfile);
        }
        echo "yeeterino";
    } else if ($type == "psts") {
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $sql = "SELECT * FROM scribbles";

        $result = $conn->query($sql) or die($conn->error);
        while ($row = $result->fetch_assoc()) {
            if (!file_exists('../scribble/' . $row['id'])) {
                mkdir('../scribble/' . $row['id'], 0777, true);
            }
            $srcfile = '../scribble/redir.php';
            $destfile = '../scribble/' . $row['id'] . "/index.php";
            copy($srcfile, $destfile);
        }
        echo "yeet";
    }

?>