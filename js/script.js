function previewImage(id) {
    let file = document.getElementById(id).files;
    if (file.length > 0) {
        let fileReader = new FileReader();
        fileReader.onload = e => {
            document.getElementById('preview').setAttribute('src', String(e.target.result));
            document.getElementById('preview').style.display = 'inline';
            document.getElementById('form').style.display = 'none';
            document.getElementById('save').style.display = 'inline';
        };

        fileReader.readAsDataURL(file[0]);
    }
}

function previewImageEdit(id) {
    let file = document.getElementById(id).files;
    if (file.length > 0) {
        let fileReader = new FileReader();
        fileReader.onload = e => {
            document.getElementById('edit_del').style.display = 'none';
            document.getElementById('preview').style.display = 'none';
            document.getElementById('user_cover_photo').style.display = 'none';
            document.getElementById('previewEdit').setAttribute('src', String(e.target.result));
            document.getElementById('previewEdit').style.display = 'inline';
            document.getElementById('edit_save').style.display = 'inline';
        };

        fileReader.readAsDataURL(file[0]);
    }
}

function hide() {
    document.getElementById('form').style.display = 'none';
    document.getElementById('edit_del').style.display = 'inline';
}

function remove(user_id) {
    fetch('request.php',{
        method:'post',
        body:user_id
    }).then(response => {
        document.getElementById('edit_del').style.display = 'none';
        location.reload();
    }).catch(error => {
        return error;
    })
}


function previewProfilePhoto(){
    let img = document.getElementById('profile-img-preview');
    let file = document.getElementById('exampleFormControlFile1').files;
    if (file.length > 0) {
        let fileReader = new FileReader();
        fileReader.onload = e => {
            img.setAttribute('src', String(e.target.result));
            img.style.display = 'inline';
        };

        fileReader.readAsDataURL(file[0]);
    }
}