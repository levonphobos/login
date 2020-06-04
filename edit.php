<?php

session_start();

if (!empty($_FILES)) {
    $conn = new mysqli('localhost', 'root', '', 'user_login');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user_id = $_SESSION['user_id'];
    $filename = $_FILES['edit_cover']['name'];

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($filename);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    move_uploaded_file($_FILES["edit_cover"]["tmp_name"], $target_file);

    $sql = "UPDATE cover_photo SET name='$filename' WHERE user_id='$user_id'";

    if ($conn->query($sql) === true) {
        $_SESSION['cover_photo'] = $filename;
        header("location:home.php");
    };

    $conn->close();
}