<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = file_get_contents('php://input');
    $user_id = (int)$user_id;

    $conn = new mysqli('localhost', 'root', '', 'user_login');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DELETE FROM cover_photo WHERE user_id='$user_id'";

    if($conn->query($sql) === true){
        $_SESSION['cover_photo'] = '';
    } else {
        echo "Failed";
    }
}

