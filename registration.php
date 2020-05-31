<?php

session_start();
$_SESSION['message'] = '';


$conn = new mysqli('localhost', 'root', '', 'user_login');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];
$filename = $_FILES['photo']['name'];

$target_dir = "uploads/";
$target_file = $target_dir . basename($filename);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);

$sql = "INSERT INTO user_table (username, password, photo)
VALUES ('$username', '$password', '$filename')";

if ($conn->query($sql) === TRUE) {
    header('location:index.php');
} else {
    $_SESSION['message'] = "Registration Failed";
    header('location:register.php');
}

$conn->close();