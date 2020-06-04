<?php

session_start();
$_SESSION['error'] = '';
$_SESSION['username'] = '';
$_SESSION['photo'] = '';
$_SESSION['user_id'] = '';
$_SESSION['cover_photo'] = '';


$conn = new mysqli('localhost', 'root', '', 'user_login');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];
$password = md5($password);


$sql = "SELECT * FROM user WHERE username='$username' && password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $_SESSION['username'] = $row["username"];
        $_SESSION['photo'] = $row["photo"];
        $_SESSION['user_id'] = $row["id"];
    }
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT name FROM cover_photo WHERE user_id='$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $_SESSION['cover_photo'] = $row["name"];
        }
    } else {
        $_SESSION['cover_photo'] = '';
    }

    header('location:home.php');
} else {
    $_SESSION['error'] = "Login Failed";
    header('location:index.php');
}

$conn->close();