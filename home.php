<?php
session_start();

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<h2>Welcome Dear <?php echo $_SESSION['username'] ?></h2>

<img src="uploads/<?php echo $_SESSION['photo']?>" class="img-thumbnail" width="200" alt="Profile Picture">

</body>
</html>