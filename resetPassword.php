<?php
require_once 'classes/Session.php';
require_once 'classes/User.php';

Session::start();

if (!isset($_GET['code'])) {
    exit("Can't find page");
}

if (!($_GET['code'] === Session::get('code'))) {
    exit("Can't find page");
}

if (isset($_POST['reset-password'])) {
    $newPass = md5($_POST['reset-password']);
    $values = array('password' => $newPass);
    $keys = array('email' => Session::get('reset-email'));
    print_r($values);
    echo '<br>';
    print_r($keys);
    $user = new User();
    if ($user->edit($values, $keys)) {
        Session::set('send-mail-response', 'Password Update');
    } else {
        Session::set('send-mail-response', 'Something Went Wrong. Please Try Again.');
    }
    Session::set('code', '');
    Session::set('reset-email', '');
    header('location:index.php');
}


?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4 pt-5">
            <form action="" method="post" align="center">
                <h3>New Password </h3><br>
                    <input class="form-control" type="password" name="reset-password">
                <br><br>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>