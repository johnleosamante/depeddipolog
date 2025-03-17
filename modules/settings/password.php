<?php
// modules/settings/password.php
?>
<div class="tab-pane fade" id="password-change">
    <div class="row">
        <div class="col">
            <div class="my-2 p-3 rounded alert-info text-left d-flex">
                <span class="d-inline-block m-2">
                    <i class="fas fa-info fa-2x"></i>
                </span>
                <span class="ml-2 d-inline-block d-flex align-items-center">
                    <div>To help secure your account, please use atleast one (1) uppercase, atleast one (1) lowercase, atleast one (1) number and atleast one (1) special character to your password that should be atleast ten (10) characters long. Alternatively, you can click the generate button to get a password you can use instead.</div>
                </span>
            </div>
        </div>
    </div>

    <form class="py-2" action="" method="POST">
        <div class="row">
            <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
                <div class="form-group">
                    <label for="old-password" class="mb-0">Old Password <?php showAsterisk() ?></label>
                    <div class="input-group">
                        <input id="old-password" name="old-password" type="password" class="form-control border-right-0" value="<?= $oldPassword ?>" required>
                        <div class="input-group-append">
                            <button type="button" id="old-eye-toggle" class="input-group-text border-left-0 bg-white">
                                <i id="old-eye" class="small fas fa-eye fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
                <div class="form-group">
                    <label for="password" class="mb-0">New Password <?php showAsterisk() ?></label>
                    <div class="input-group">
                        <input id="password" name="password" type="password" class="form-control border-right-0" value="<?= $password ?>" required>
                        <div class="input-group-append">
                            <button type="button" id="eye-toggle" class="input-group-text border-left-0 bg-white">
                                <i id="eye" class="small fas fa-eye fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
                <div class="form-group">
                    <label for="password-confirm" class="mb-0">Retype New Password <?php showAsterisk() ?></label>
                    <div class="input-group">
                        <input id="password-confirm" name="password-confirm" type="password" class="form-control border-right-0" value="<?= $passwordConfirm ?>" required>
                        <div class="input-group-append">
                            <button type="button" id="eye-confirm-toggle" class="input-group-text border-left-0 bg-white">
                                <i id="eye-confirm" class="small fas fa-eye fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
                <div class="form-group">
                    <label for="generate-password" class="mb-0">Generate Password</label>
                    <div class="input-group">
                        <input id="generate-password" name="generate-password" type="text" class="form-control" value="<?= $generatePassword ?>">
                        <div class="input-group-append">
                            <button type="button" id="generate-toggle" class="input-group-text">
                                Generate
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php requiredLegend() ?>

        <div class="row">
            <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
                <input name="update-password" type="submit" value="Update Password" class="btn btn-primary btn-block btn-lg">
            </div>
        </div>
    </form>
</div>