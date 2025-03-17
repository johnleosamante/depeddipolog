<?php
// login/reset/page.php
?>
<div class="col-xl-5 col-lg-5 col-md-8 col-sm-12">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-header">
            <h3 class="text-center my-2">Reset Password</h3>
        </div>

        <div class="card-body text-center">
            <?php displayLogo(120, 120, '3', uri(), title()) ?>

            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>

                <p class="mb-4">
                    Enter your email address below and we will send you the instruction to reset your password.
                </p>
            </div>

            <?php messageAlert($showAlert, $message, $success) ?>

            <form action="" method="POST">
                <div class="form-group">
                    <input class="form-control" id="email" name="email" type="email" placeholder="juan.delacruz@deped.gov.ph" value="<?= $userEmail ?>" autofocus required>
                </div>

                <button type="submit" class="btn btn-primary btn-block" name="reset-password">Reset Password</button>
            </form>
        </div>

        <div class="card-footer text-center">
            <a class="small" href="<?= uri() . '/login' ?>" title="Login to your account">Login to your account instead</a>
        </div>
    </div>
</div>