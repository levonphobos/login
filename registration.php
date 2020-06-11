<?php

session_start();

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

    <style>
        .upload-img {
            display: none;
        }

        .preview-img {
            margin: -10px 0 0 50px;
            width: 50px;
            display: none;
        }
    </style>
</head>
<body>

<!--Register-->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4 pt-5">
            <h2>Registration</h2>
            <form method="post" action="database.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="exampleInputEmail1">Username</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                           name="register-username" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="register-password" required>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlFile1" class="btn btn-success">Upload Photo</label>
                    <input onchange="previewProfilePhoto()" type="file" class="form-control-file upload-img" id="exampleFormControlFile1" name="register-photo"
                           required>
                    <img id="profile-img-preview" src="" alt="Your Image" class="img-thumbnail preview-img"/>
                </div>
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
            <h3><?php if (isset($_SESSION['reg-error'])) {
                    echo $_SESSION['reg-error'];
                } ?></h3>
        </div>
    </div>
</div>

<!--Register-->

<script src="js/script.js"></script>
</body>
</html>