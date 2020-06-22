<?php

require_once 'classes/Session.php';
Session::start();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $to = $_POST['send-email'];
    Session::set('reset-email', $_POST['send-email']);
    $subject = "Reset Password";
    $code= uniqid();
    Session::set('code', $code);
    $url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/resetPassword.php?code=$code";
    $txt = '
<h3>
You are requested a password reset
</h3>
<p>Click <a href="'.$url.'">this link</a> to do so</p>
';
    $headers = "From: lauramamunc11@gmail.com";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
    $headers .= 'From: <webmaster@example.com>' . "\r\n";
    $headers .= 'Cc: myboss@example.com' . "\r\n";
    if(mail($to,$subject,$txt, $headers)){
        Session::set('send-mail-response', 'We send update URL on your mail.');
    } else{
        Session::set('send-mail-response', 'Wrong email. Please try again.');
    }
    header('location:index.php');
}