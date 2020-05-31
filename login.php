<?php

session_start();
$_SESSION['error'] = '';
$_SESSION['username'] = '';
$_SESSION['photo'] = '';


$conn = new mysqli('localhost', 'root', '', 'user_login');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];


$sql = "SELECT * FROM user_table WHERE username='$username' && password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $_SESSION['username'] = $row["username"];
        $_SESSION['photo'] = $row["photo"];
        header('location:home.php');
    }
} else {
    $_SESSION['error'] = "Login Failed";
    header('location:index.php');
}

$conn->close();