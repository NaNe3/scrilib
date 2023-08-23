<?php
//    $con = array("e", "L", "i", "I", "3", "6", "o", "0", "1");
    session_start();
    
//    function getLen() {
//        $conn = new mysqli("localhost", "root", "", "scrilib");
//        // Check connection
//        if ($conn->connect_error) {
//            die("Connection failed: " . $conn->connect_error);
//        } 
//        $sql = "SELECT * FROM scribbles";
//        
//        $result = $conn->query($sql) or die($conn->error);
//        return $result->num_rows;
//    }

    function StyleApp($mod) {
        $conn = new mysqli("localhost", "root", "", "scrilib");
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "UPDATE styles SET scribbles=scribbles+1 WHERE style = '" . $mod . "'";

        $conn->query($sql);
    }

    function incAcc($user) {
        $conn = new mysqli("localhost", "root", "", "scrilib");
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "UPDATE users SET scribbles=scribbles+1 WHERE name = '" . $user . "'";

        $conn->query($sql);
    }

    function makePost($fileName, $data) {
        $conn = new mysqli("localhost", "root", "", "scrilib");
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        if (isset($_POST['check'])) {
            $anon = "true";
        } else {
            $anon = "false";
        }
        
        $date = date("M j");

        $sql = "INSERT INTO scribbles (date, style, name, author, img, anon, width, height, rating, views) VALUES ('" . $date . "', '" . $_POST["genre"] . "', '" . $_POST['name'] . "', '" . $_SESSION['user'] . "', '" . $fileName . "', " . $anon . ", " . $_POST['width'] . ", " . $_POST['height'] . ", 0, 0)";

        if ($conn->query($sql) === TRUE) {
            StyleApp('New');
            if ($_POST['genre'] != "New") {
                StyleApp($_POST['genre']);
            }
            incAcc($_SESSION['user']);
            
            $last_id = $conn->insert_id;
            
            if (!file_exists('../scribble/' . $last_id)) {
                mkdir('../scribble/' . $last_id, 0777, true);
            }
            $srcfile = '../scribble/redir.php'; 
            $destfile = '../scribble/' . $last_id . "/index.php"; 
            copy($srcfile, $destfile);
            file_put_contents("../scribble/". $last_id . "/" . $fileName, $data);
            
            echo "<script>window.location = '../scribble/" . $last_id . "';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    
    if (isset($_SESSION['user'])) {
        $img = $_POST['img'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        //$file = '../scribble/img'.date("YmdHis").'.png';
        $file = 'img'.date("YmdHis").'.png';
        
        makePost($file, $data);
//        if (file_put_contents($file, $data)) {
//            echo "<p>The canvas was saved as $file.</p>";
//            makePost($file);
//        } else {
//            echo "<p>The canvas could not be saved.</p>";
//        }   
    } else {
        echo "LETS GET OUT OF HERER";
    }
?>