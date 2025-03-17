<?php
// modules/error/not-found.php
?>

<div class="text-center py-0">
    <?php missingAlert('No results found', 'fa-search', 'text-gray-800') ?>

    <p class="text-gray-700 mt-4 mb-1">Try a new search term instead</p>

    <form class="mx-auto mb-4" method="POST" action="">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-10 col-sm-12">
                <div class="input-group">
                    <input type="text" class="form-control small" placeholder="Search..." aria-label="Search" name="primary-search-text" autofocus required>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit" name="primary-search-button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php if (isset($userId)) : ?>
        <a href="<?= uri() . '/' . $activeApp ?>" title="Go to dashboard">Go to Dashboard</a>
    <?php endif ?>
</div>