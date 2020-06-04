<?php

session_start();
$_SESSION['message'] = '';


$conn = new mysqli('localhost', 'root', '', 'user_login');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];
$password = md5($password);
$filename = $_FILES['photo']['name'];

$target_dir = "uploads/";
if(!is_dir($target_dir)){
    mkdir($target_dir, 0777, true);
}
$target_file = $target_dir . basename($filename);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);

$sql = "INSERT INTO user (username, password, photo)
VALUES ('$username', '$password', '$filename')";

if ($conn->query($sql) === TRUE) {
    $_SESSION['error'] = '';
    $_SESSION['message'] = "";
    $sql = "SELECT * FROM user WHERE username='$username' && password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $_SESSION['username'] = $row["username"];
            $_SESSION['photo'] = $row["photo"];
            $_SESSION['user_id'] = $row["id"];
        }

        $user_id = $row["id"];

        $sql = "SELECT name FROM cover_photo WHERE user_id='$user_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $_SESSION['cover_photo'] = $row["name"];
            }
        } else {
            $_SESSION['cover_photo'] = '';
        }
    }
    header('location:home.php');
} else {
    $_SESSION['message'] = "Registration Failed";
    header('location:register.php');
}

$conn->close();