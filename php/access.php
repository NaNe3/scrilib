<?php
    $mode = $_GET["mod"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "scrilib";

    if ($mode == "up") {
        if (empty($_POST['fname']) != true && empty($_POST['lname']) != true && empty($_POST['user']) != true && empty($_POST['pass']) != true) {
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            
            $rand = rand(0,27) . '.png';
            $sql = "INSERT INTO users (name, img, fname, lname, email, password, scribbles, following, followers, saves, upvoted, downvoted) VALUES ('" . $_POST['user'] . "', '" . $rand . "', '" . $_POST['fname'] . "', '" . $_POST['lname'] . "', '" . $_POST['email'] . "', '" . $_POST['pass'] . "', 0, ',Scrilibr', ',Scrilibr', '', '', '')";

            if ($conn->query($sql) === TRUE) {
                session_start();
                
                $_SESSION['user'] = $_POST['user'];
                $_SESSION["fname"] = $_POST['fname'];
                $_SESSION["lname"] = $_POST['lname'];
                $_SESSION["src"] = $rand;
                $_SESSION["auth"] = true;
                
                if (!file_exists('../user/' . $_POST['user'])) {
                    mkdir('../user/' . $_POST['user'], 0777, true);
                }
                $srcfile = '../user/redir.php';
                $destfile = '../user/' . $_POST['user'] . "/index.php";
                copy($srcfile, $destfile);
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            $conn->close(); 
            
            //SUBMIT SECOND ROUND
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "UPDATE users SET followers=CONCAT(followers, '," . $_POST['user'] . "'),following=CONCAT(following, '," . $_POST['user'] . "') WHERE name = 'Scrilibr'";
            if ($conn->query($sql) === TRUE) {
                echo "<script>window.location='../';</script>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            $conn->close();
        }
    } else if ($mode == "in") {
        if (empty($_POST['user']) != true && empty($_POST['pass']) != true) {
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 

            $sql = "SELECT * FROM users WHERE name = '" . $_POST['user'] . "' AND password = '" . $_POST['pass'] . "' OR email = '" . $_POST['user'] . "' AND password = '" . $_POST['pass'] . "'";

            $arr = array();
            $result = $conn->query($sql) or die($conn->error);
            while ($row = $result->fetch_assoc()) {
                $arr[] = $row;
                session_start();
                
                $_SESSION['user'] = $row['name'];
                $_SESSION["fname"] = $row['fname'];
                $_SESSION["lname"] = $row['lname'];
                $_SESSION["src"] = $row['img'];
                $_SESSION["auth"] = true;
            }

            if (count($arr) == 0) {
                echo "<script>window.location = '../p/signin/'</script>"; 
            } else { 
                echo "<script>window.location = '../';</script>";
            } 
        }
    }
    
?>