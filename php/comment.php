<?php
    session_start();
    $type = $_GET["typ"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "scrilib";

    $conn = new mysqli("localhost", "root", "", "scrilib");
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $date = date("M j");

    $sql = "INSERT INTO comments (type, no, com, author, points, comment, date) VALUES ('" . $_GET['typ'] . "', " . $_GET['no'] . ", " . $_GET['com'] . ", '" . $_SESSION['user'] . "', 0, '" . $_GET['mainCom'] . "', '" . $date . "')";

    $conn->query($sql);
?>