<?php
require 'classes/Session.php';
require_once 'classes/User.php';
require_once 'classes/CoverPhoto.php';
require_once 'classes/UserPost.php';
Session::start();

switch ($_SERVER["REQUEST_METHOD"] == "POST"){
    case (isset($_POST['register-username']) && isset($_FILES['register-photo']['name']) && isset($_POST['register-password'])):
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . basename($_FILES['register-photo']['name']);
        move_uploaded_file($_FILES['register-photo']["tmp_name"], $target_file);
        $data = array("name" => $_POST['register-username'], "photo" => $_FILES['register-photo']['name'], 'email'=> $_POST['register-email'], "password" => md5($_POST['register-password']));
        $user = new User();
        if ($user->save($data)) {
            Session::set('reg-error', '');
            $loginData = array('name' => $data['name'], 'password' => $data['password']);
            $user->login($loginData);
            if (Session::get('select_result')->num_rows > 0) {
                while ($row = Session::get('select_result')->fetch_assoc()) {
                    Session::set('name', $row['name']);
                    Session::set('photo', $row['photo']);
                    Session::set('user_id', $row['id']);
                }
                Session::set('send-mail-response', '');
                header('location:home.php');
            } else {
                Session::set('login-error', 'Login Failed');
                header("location:index.php");
            }
        } else {
            Session::set('reg-error', 'Registration Failed');
            header('location:registration.php');
        }
        break;

    case (isset($_POST['login-name']) && isset($_POST['login-password'])):
        $loginData = array("name" => $_POST['login-name'], "password" => md5($_POST['login-password']));
        $user = new User();
        $user->login($loginData);
        if (Session::get('select_result')->num_rows > 0) {
            Session::set('login-error', '');
            while ($row = Session::get('select_result')->fetch_assoc()) {
                Session::set('name', $row['name']);
                Session::set('photo', $row['photo']);
                Session::set('user_id', $row['id']);
            }
            Session::set('send-mail-response', '');
            $coverPhoto = new CoverPhoto();
            $data = array('user_id' => Session::get('user_id'));
            $coverPhoto->getCoverPhoto($data);
            if (Session::get('select_result')->num_rows > 0) {
                while ($row = Session::get('select_result')->fetch_assoc()) {
                    Session::set('cover-photo', $row['name']);
                }
            } else {
                Session::set('cover-photo', '');
            }
            $userPost = new UserPost();
            $userPost->getPosts($data);
            if (Session::get('select_result')->num_rows > 0) {
                Session::set('posts',Session::get('select_result')->fetch_all());
            } else {
                Session::set('posts', []);
            }
            header('location:home.php');
        } else {
            Session::set('login-error', 'Login Failed');
            header("location:index.php");
        }
        break;

    case (isset($_FILES['add-cover']['name'])):
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES['add-cover']['name']);
        move_uploaded_file($_FILES['add-cover']["tmp_name"], $target_file);
        $data = array("name" => $_FILES['add-cover']['name'], 'user_id' => Session::get('user_id'));
        $coverPhoto = new CoverPhoto();
        if ($coverPhoto->save($data)) {
            Session::set('cover-photo', $data['name']);
        }
        header("location:home.php");
        break;
    case (isset($_FILES['edit-cover']['name'])):
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES['edit-cover']['name']);
        move_uploaded_file($_FILES['edit-cover']["tmp_name"], $target_file);
        $values = array("name" => $_FILES['edit-cover']['name']);
        $keys = array('user_id' => Session::get('user_id'));
        $coverPhoto = new CoverPhoto();
        if ($coverPhoto->edit($values, $keys)) {
            Session::set('cover-photo', $_FILES['edit-cover']['name']);
        }
        header("location:home.php");
        break;

    case(isset($_POST['delete-cover'])):
        $coverPhoto = new CoverPhoto();
        $data = array('user_id' => Session::get('user_id'));
        if($coverPhoto->remove($data)){
            Session::set('cover-photo', '');
        }
        header("location:home.php");
        break;

    case(isset($_POST['user-post'])):
        $userPost = new UserPost();
        $data = array('content' => $_POST['user-post'], 'user_id' => Session::get('user_id'));
        if($userPost->save($data)){
            $data = array('user_id' => Session::get('user_id'));
            $userPost->getPosts($data);
                if (Session::get('select_result')->num_rows > 0) {
                    Session::set('posts', Session::get('select_result')->fetch_all());
                } else {
                    Session::set('posts', []);
                }
        }
        header("location:home.php");
        break;

    case(isset($_POST)):
        foreach($_POST as $key => $value) {
            if (preg_match('/post-delete/i', $key)) {
                $data = array('id' => $value);
                $userPost = new UserPost();
                if($userPost->remove($data)){
                    $data = array('user_id' => Session::get('user_id'));
                    $userPost->getPosts($data);
                    if (Session::get('select_result')->num_rows > 0) {
                        Session::set('posts', Session::get('select_result')->fetch_all());

                    } else {
                        Session::set('posts', []);
                    }
                }
            }
        }
        header("location:home.php");
}