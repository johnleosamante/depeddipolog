<?php
// modules/error/404.php
?>

<div class="text-center py-0">
    <div class="error mx-auto" data-text="404">404</div>
    <p class="lead text-gray-800 mt-1 mb-0">Page not found</p>
    <p class="text-gray-500 mb-4">Sorry, we couldn't find what you're looking for...</p>

    <?php if (isset($userId)) : ?>
        <a href="<?= uri() . '/' . $activeApp ?>" title="Go to dashboard">Go to dashboard</a>
    <?php else : ?>
        <a href="<?= uri() ?>" title="Go to home page">Go to home page</a>
    <?php endif ?>
</div>