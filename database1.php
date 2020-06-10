<?php

session_start();
$_SESSION['login-error'] = "";


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
    protected string $table;

    protected function insert($data)
    {
        $sql = "INSERT INTO $this->table (" . implode(", ", array_keys($data)) . ") 
        VALUES('" . implode("', '", array_values($data)) . "')";
        if ($this->conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    protected function select($data)
    {
        $condition = array();
        foreach ($data as $key => $value) {
            $condition[] = "{$key} = '{$value}'";
        }
        $condition = join(' AND ', $condition);


        $sql = "SELECT * FROM $this->table WHERE {$condition}";
        if ($this->conn->query($sql)) {
            $_SESSION['select-result'] = $this->conn->query($sql);
        } else {
            $_SESSION['select-result'] = '';
        }
    }

    protected function update($values, $ids)
    {
        $valueSets = array();
        foreach ($values as $key => $value) {
            $valueSets[] = $key . " = '" . $value . "'";
        }

        $conditionSets = array();
        foreach ($ids as $key => $value) {
            $conditionSets[] = $key . " = '" . $value . "'";
        }

        $sql = "UPDATE $this->table SET " . join(",", $valueSets) . " WHERE " . join(" AND ", $conditionSets);

        if ($this->conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    protected function delete($data)
    {
        $condition = array();
        foreach ($data as $key => $value) {
            $condition[] = "{$key} = '{$value}'";
        }

        $condition = join(' AND ', $condition);
        $sql = "DELETE FROM $this->table WHERE {$condition}";
        if ($this->conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }
}


class User extends DbTable
{
    protected string $table = "user";

    function save($data)
    {
        if ($this->insert($data)) {
            return true;
        } else {
            return false;
        }
    }

    function login($data)
    {
        $this->select($data);
    }
}


class CoverPhoto extends DbTable
{
    protected string $table = 'cover_photo';

    function save($data)
    {
        if ($this->insert($data)) {
            return true;
        } else {
            return false;
        }
    }

    function getCoverPhoto($data)
    {
        $this->select($data);
    }

    function edit($values, $ids)
    {
        if ($this->update($values, $ids)) {
            return true;
        } else {
            return false;
        }
    }

    function remove($data)
    {
        if($this->delete($data)){
            return true;
        } else {
            return false;
        }
    }

}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['register-username']) && isset($_FILES['register-photo']['name']) && isset($_POST['register-password'])) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . basename($_FILES['register-photo']['name']);
        move_uploaded_file($_FILES['register-photo']["tmp_name"], $target_file);
        $data = array("name" => $_POST['register-username'], "photo" => $_FILES['register-photo']['name'], "password" => md5($_POST['register-password']));
        $user = new User();
        if ($user->save($data)) {
            $_SESSION['reg-error'] = '';
            $loginData = array('name' => $data['name'], 'password' => $data['password']);
            $user->login($loginData);
            if ($_SESSION['select-result']->num_rows > 0) {
                while ($row = $_SESSION['select-result']->fetch_assoc()) {
                    $_SESSION['name'] = $row["name"];
                    $_SESSION['photo'] = $row["photo"];
                    $_SESSION['user_id'] = $row["id"];
                }
                header('location:home.php');
            } else {
                $_SESSION['login-error'] = "Login Failed";
                header("location:index.php");
            }
        } else {
            $_SESSION['reg-error'] = "Registration Failed";
            header('location:registration.php');
        }
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login-name']) && isset($_POST['login-password'])) {
        $loginData = array("name" => $_POST['login-name'], "password" => md5($_POST['login-password']));
        $user = new User();
        $user->login($loginData);
        if ($_SESSION['select-result']->num_rows > 0) {
            $_SESSION['login-error'] = '';
            while ($row = $_SESSION['select-result']->fetch_assoc()) {
                $_SESSION['name'] = $row["name"];
                $_SESSION['photo'] = $row["photo"];
                $_SESSION['user_id'] = $row["id"];
            }
            $coverPhoto = new CoverPhoto();
            $data = array('user_id' => $_SESSION['user_id']);
            $coverPhoto->getCoverPhoto($data);
            if ($_SESSION['select-result']->num_rows > 0) {
                while ($row = $_SESSION['select-result']->fetch_assoc()) {
                    $_SESSION['cover-photo'] = $row["name"];
                }
            } else {
                $_SESSION['cover-photo'] = '';
            }
            header('location:home.php');
        } else {
            $_SESSION['login-error'] = "Login Failed";
            header("location:index.php");
        }
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['add-cover']['name'])) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . basename($_FILES['add-cover']['name']);
        move_uploaded_file($_FILES['add-cover']["tmp_name"], $target_file);
        $data = array("name" => $_FILES['add-cover']['name'], 'user_id' => $_SESSION['user_id']);
        $coverPhoto = new CoverPhoto();
        if ($coverPhoto->save($data)) {
            $_SESSION['cover-photo'] = $data['name'];
        }
        header("location:home.php");
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['edit-cover']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES['edit-cover']['name']);
        move_uploaded_file($_FILES['edit-cover']["tmp_name"], $target_file);
        $values = array("name" => $_FILES['edit-cover']['name']);
        $ids = array('user_id' => $_SESSION['user_id']);
        $coverPhoto = new CoverPhoto();
        if ($coverPhoto->edit($values, $ids)) {
            $_SESSION['cover-photo'] = $_FILES['edit-cover']['name'];
        }
        header("location:home.php");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete-cover'])) {
        $coverPhoto = new CoverPhoto();
        $data = array('user_id' => $_SESSION['user_id']);
        if($coverPhoto->remove($data)){
            $_SESSION['cover-photo'] = '';
        }
        header("location:home.php");
    }
}