<?php

require 'classes/Session.php';
Session::start();

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
<!--Login-->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4 pt-5">
            <h2>Login</h2>
            <form method="post" action="request.php">
                <div class="form-group">
                    <label for="exampleInputEmail1">Username</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                           name="login-name" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="login-password"
                           required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <p>Don't have an account? <a href="registration.php">Create Account</a></p>
            <button type="button" class="btn btn-link pl-0" data-toggle="modal" data-target="#exampleModal">
                Forget Password
            </button>
            <h5><?php
                if (Session::get('login-error')) {
                    echo Session::get('login-error');
                }

                if(Session::get('send-mail-response')){
                    echo Session::get('send-mail-response');
                }
                ?></h5>
        </div>
    </div>
</div>

<!--Login-->

<!-- Modal-->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="sendMail.php" autocomplete="on" enctype="multipart/form-data" method="post" id="send-mail-form">
                    <label for="exampleInputEmail2">Email address</label>
                    <input type="email" class="form-control" name="send-email" id="exampleInputEmail2" aria-describedby="emailHelp">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" form="send-mail-form" class="btn btn-primary">Send Mail</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal-->

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
        crossorigin="anonymous"></script>
</body>
</html>