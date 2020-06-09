<?php

session_start();

class Database
{
    public object $conn;

    function __construct()
    {
        $this->conn = new mysqli('localhost', 'root', '', 'login');
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    function __destruct()
    {
        $this->conn->close();
    }
}

class DbTable extends Database
{
    function insert($name, $photo, $password, $type)
    {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($photo);

        move_uploaded_file($_FILES["register-photo"]["tmp_name"], $target_file);

        $sql = "INSERT INTO user (name, photo, password)
VALUES ('$name', '$photo', '$password')";

        if ($this->conn->query($sql) === TRUE) {
            $this->select($name, $password, $type);
        } else {
            echo "$type Failed";
        }
    }

    function select($name, $password, $type)
    {
        $_SESSION['error'] = "";
        $_SESSION['message'] = "";
        $sql = "SELECT * FROM user WHERE name='$name' && password='$password'";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $_SESSION['name'] = $row["name"];
                $_SESSION['photo'] = $row["photo"];
                $_SESSION['user_id'] = $row["id"];
            }

            $user_id = $_SESSION['user_id'];
            $user = new User();
            $user->getCoverPhoto($user_id);
            header('location:home.php');
        } else {
            if ($type == 'Registration') {
                $_SESSION['message'] = "$type Failed";
                header("location:registration.php");
            }
            if ($type == 'Login') {
                $_SESSION['error'] = "$type Failed";
                header("location:index.php");
            }
        }
    }
}

class User extends DbTable
{

    function getCoverPhoto($user_id)
    {
        $sql = "SELECT name FROM cover_photo WHERE user_id='$user_id'";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $_SESSION['cover-photo'] = $row["name"];
            }
        } else {
            $_SESSION['cover-photo'] = '';
        }
    }

    function addCoverPhoto($user_id, $photo)
    {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($photo);

        move_uploaded_file($_FILES["cover-photo"]["tmp_name"], $target_file);

        $sql = "INSERT INTO cover_photo (name, user_id)
    VALUES ('$photo', '$user_id')";

        if ($this->conn->query($sql) === true) {
            $_SESSION['cover-photo'] = $photo;
        }
        header("location:home.php");

    }

    function editCoverPhoto($user_id, $photo)
    {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($photo);

        move_uploaded_file($_FILES["edit-cover"]["tmp_name"], $target_file);

        $sql = "UPDATE cover_photo SET name='$photo' WHERE user_id='$user_id'";

        if ($this->conn->query($sql) === true) {
            $_SESSION['cover-photo'] = $photo;
            header("location:home.php");
        };
    }

    function deleteCoverPhoto($user_id)
    {
        $sql = "DELETE FROM cover_photo WHERE user_id='$user_id'";

        if ($this->conn->query($sql) === true) {
            $_SESSION['cover-photo'] = '';
        }
    }


}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['register-username']) && isset($_FILES['register-photo']['name']) && isset($_POST['register-password'])) {
        $dbTable = new DbTable();
        return $dbTable->insert($_POST['register-username'], $_FILES['register-photo']['name'], md5($_POST['register-password']), 'Registration');
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login-name']) && isset($_POST['login-password'])) {
        $dbTable = new DbTable();
        return $dbTable->select($_POST['login-name'], md5($_POST['login-password']), 'Login');
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['cover-photo']['name'])) {
        $user = new User();
        return $user->addCoverPhoto($_SESSION['user_id'], $_FILES['cover-photo']['name']);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['edit-cover']['name'])) {
        $user = new User();
        return $user->editCoverPhoto($_SESSION['user_id'], $_FILES['edit-cover']['name']);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (file_get_contents('php://input')) {
        $user = new User();
        return $user->deleteCoverPhoto((int)file_get_contents('php://input'));
    }
}