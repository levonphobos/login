<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $to = $_POST['send-email'];
    $subject = "From PHP";
    $txt = '
<h1 style="text-align: center; border:3px groove red; color: blue; border-radius: 8px;">' .$_POST['send-textarea'] .'</h1>
';
    $headers = "From: lauramamunc11@gmail.com";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
    $headers .= 'From: <webmaster@example.com>' . "\r\n";
    $headers .= 'Cc: myboss@example.com' . "\r\n";
    if(mail($to,$subject,$txt, $headers)){
        echo "Yes";
    } else{
        echo "no";
    }
}