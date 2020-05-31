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
</head>
<body>

<!--Login-->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4 pt-5">
            <h2>Login</h2>
            <form method="post" action="login.php">
                <div class="form-group">
                    <label for="exampleInputEmail1">Username</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                           name="username" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <h5><a href="register.php">Register Now</a></h5>
            <h5><?php echo $_SESSION['error'] ?></h5>
        </div>
    </div>
</div>

<!--Login-->

</body>
</html>