<?php
session_start();
if (!$_SESSION['user_id']) {
    header('location:index.php');
}


if (!empty($_FILES)) {
    $conn = new mysqli('localhost', 'root', '', 'user_login');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user_id = $_SESSION['user_id'];
    $filename = $_FILES['cover_photo']['name'];

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($filename);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    move_uploaded_file($_FILES["cover_photo"]["tmp_name"], $target_file);

    $sql = "INSERT INTO cover_photo (name, user_id)
    VALUES ('$filename', '$user_id')";

    if ($conn->query($sql) === true) {
        $_SESSION['cover_photo'] = $filename;
    };

    header("Refresh:0");

    $conn->close();
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
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/fontawesome-all.css">
    <title>Document</title>
</head>
<body>

<div class="photo_block">
    <div>
        <img src="uploads/<?php echo $_SESSION['photo'] ?>" class="img-thumbnail" alt="Profile Picture">
        <h4><?php echo $_SESSION['username'] ?></h4>
    </div>
    <?php if (!$_SESSION['cover_photo']) {
        echo '
        <form method="post" action="" id="form" enctype="multipart/form-data" class="cover_photo_upload_form">
        <label for="cover" class="cover_inp" title="Upload Cover Photo"><img src="images/add.png" alt="Add"></label>
        <input id="cover" type="file" name="cover_photo" required onchange="previewImage(this.id)">
    </form>
    <button form="form" type="submit" onclick="hide()" class="btn btn-success save_btn" id="save" style="display: none;">
    Save
    </button>
        ';
    } ?>

    <img src="" id="preview" class="img-thumbnail preview_img" alt="preview">

    <img src="" id="previewEdit" class="img-thumbnail preview_img" alt="preview">


    <?php if ($_SESSION['cover_photo']) {
        echo '<img id="user_cover_photo" src="uploads/' . $_SESSION['cover_photo'] . '" class="img-thumbnail" style="width:100%;" alt="Profile Picture">';
    } ?>

<?php if ($_SESSION['cover_photo']) {

    echo '<div id="edit_del" class="edit-del">
        <form action="edit.php" method="post" enctype="multipart/form-data" id="edit_form" style="display: inline;">
            <label title="Edit Cover Photo" for="edit" style="cursor: pointer;"><i class="far fa-edit"></i></label>
            <input type="file" id="edit" name="edit_cover" style="display: none;" onchange="previewImageEdit(this.id)">
        </form>
        <button title="Delete Cover Photo" onclick="remove(' . $_SESSION['user_id'] . ')">
            <i class="fas fa-trash-alt"></i></button>
    </div>';
}
    ?>

    <button id="edit_save" form="edit_form" type="submit" class="btn btn-success save_btn" style="display: none;">
        Save
    </button>


</div>

<button type="button" class="btn btn-primary logout_btn">
    <a href="logout.php">Logout</a>
</button>

<script src="js/script.js"></script>
</body>
</html>