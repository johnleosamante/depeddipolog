<?php
// modules/settings/profile-photo.php
$picture = fetchAssoc(employee($userId))['picture'];
?>
<div class="tab-pane fade show active" id="profile-photo">
    <div class="row">
        <div class="col">
            <div class="my-2 p-3 rounded alert-info text-left d-flex">
                <span class="d-inline-block m-2">
                    <i class="fas fa-info fa-2x"></i>
                </span>
                <span class="ml-2 d-inline-block d-flex align-items-center">
                    <div>The recommended picture size is 1:1 ratio and minimum of 400 pixels width and height.</div>
                </span>
            </div>
        </div>
    </div>

    <form action="" method="POST" enctype="multipart/form-data" class="py-2">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-7 col-xl-4">
                <?php $photo = file_exists(root() . '/' . $picture) ? uri() . '/' . $picture : uri() . '/assets/img/user.png';
                ?>
                <img src="<?= $photo ?>" width="100%" class="border rounded" id="employee-photo">

                <div class="mt-3 custom-file">
                    <input id="image-upload" type="file" name="image-upload" class="custom-file-input">
                    <label id="image-upload-label" class="custom-file-label" for="image-upload">Choose file</label>
                </div>

                <?php profilePhotoUpload('image-upload', 'employee-photo', 'image-upload-label', uri()) ?>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-sm-12 col-md-12 col-lg-7 col-xl-4">
                <input type="hidden" name="image-verifier" value="<?= cipher($employee['picture']) ?>">
                <input name="update-profile-photo" type="submit" value="Update Profile Photo" class="btn btn-primary btn-block btn-lg">
            </div>
        </div>
    </form>
</div>