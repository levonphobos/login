<?php
session_start();
if (!$_SESSION['user_id']) {
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
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/fontawesome-all.css">
    <title>Document</title>
</head>
<body>

<div class="photo_block">
    <div>
        <img src="uploads/<?php echo $_SESSION['photo'] ?>" class="img-thumbnail" alt="Profile Picture">
        <h4><?php echo $_SESSION['name'] ?></h4>
    </div>
    <?php if (!$_SESSION['cover-photo']) {
        echo '
        <form method="post" action="database1.php" id="form" enctype="multipart/form-data" class="cover_photo_upload_form">
        <label for="cover" class="cover_inp" title="Upload Cover Photo"><img src="images/add.png" alt="Add"></label>
        <input id="cover" type="file" name="add-cover" required onchange="previewImage(this.id)">
    </form>
    <button form="form" type="submit" onclick="hide()" class="btn btn-success save_btn" id="save" style="display: none;">
    Save
    </button>
        ';
    } ?>

    <img src="" id="preview" class="img-thumbnail preview_img" alt="preview">

    <img src="" id="previewEdit" class="img-thumbnail preview_img" alt="preview">


    <?php if ($_SESSION['cover-photo']) {
        echo '<img id="user_cover_photo" src="uploads/' . $_SESSION['cover-photo'] . '" class="img-thumbnail" style="width:100%;" alt="Profile Picture">';
    } ?>

    <?php if ($_SESSION['cover-photo']) {

        echo '<div id="edit_del" class="edit-del">
        <form action="database1.php" method="post" enctype="multipart/form-data" id="edit_form" style="display: inline;">
            <label for="edit" style="cursor: pointer;"><i class="far fa-edit"></i></label>
            <input type="file" id="edit" name="edit-cover" style="display: none;" onchange="previewImageEdit(this.id)">
        </form>
            <button type="button" class="delete-btn" data-toggle="modal" data-target="#exampleModal">
                <i class="fas fa-trash-alt"></i>
            </button>
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


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Cover Photo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete your cover photo?
            </div>
            <div class="modal-footer">
                <form action="database1.php" method="post" enctype="multipart/form-data" style="display: inline;">
                    <button type="submit" name="delete-cover" class="btn btn-primary">Delete</button>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
        crossorigin="anonymous"></script>
<script src="js/script.js"></script>
</body>
</html>