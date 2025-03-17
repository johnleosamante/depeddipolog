<?php
// login/change/page.php
?>

<div class="col-xl-5 col-lg-5 col-md-8 col-sm-12">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-header">
            <h3 class="text-center my-2"><?= $page ?></h3>
        </div>

        <div class="card-body text-center">
            <?php displayLogo(120, 120, '3', uri(), title()) ?>

            <div class="text-left">
                <p class="text-center mb-2">New password should have the following:</p>

                <ul id="password-requirements" class="p-0 list-unstyled">
                    <li><i id="length" class="fa fa-times text-danger mr-1"></i>Atleast ten (10) characters long</li>
                    <li><i id="uppercase" class="fa fa-times text-danger mr-1"></i>Atleast one (1) uppercase letter</li>
                    <li><i id="lowercase" class="fa fa-times text-danger mr-1"></i>Atleast one (1) lowercase letter</li>
                    <li><i id="number" class="fa fa-times text-danger mr-1"></i>Atleast one (1) number</li>
                    <li><i id="special" class="fa fa-times text-danger mr-1"></i>Atleast one (1) special character</li>
                </ul>
            </div>

            <?php messageAlert($showAlert, $message, $success) ?>

            <form action="" method="POST" class="text-left mt-3">
                <div class="form-group">
                    <label for="email-address" class="font-weight-bold mb-1">Email Address</label>
                    <input id="email-address" type="text" class="form-control border" value="<?= $email ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="password" class="font-weight-bold mb-1">New Password <?php showAsterisk() ?></label>
                    <div id="password-group" class="input-group border rounded">
                        <input id="password" name="password" type="password" class="form-control border-0" value="<?= $password ?>" required>
                        <div class="input-group-append">
                            <button type="button" id="eye-toggle" class="input-group-text border-0 bg-transparent">
                                <i id="eye" class="small fas fa-eye fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password-confirm" class="font-weight-bold mb-1">Confirm New Password <?php showAsterisk() ?></label>
                    <div id="password-confirm-group" class="input-group border rounded">
                        <input id="password-confirm" name="password-confirm" type="password" class="form-control border-0" value="<?= $passwordConfirm ?>" required>
                        <div class="input-group-append">
                            <button type="button" id="eye-confirm-toggle" class="input-group-text border-0 bg-transparent">
                                <i id="eye-confirm" class="small fas fa-eye fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <?php requiredLegend() ?>

                <button id="change-password" type="submit" class="btn btn-primary btn-block" name="change-password">Change Password</button>
            </form>
        </div>
    </div>
</div>