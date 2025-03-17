<?php
// modules/error/403.php
?>

<div class="text-center py-0">
    <div class="error mx-auto" data-text="403">403</div>
    <p class="lead text-gray-800 mt-1 mb-0">Access Denied</p>
    <p class="text-gray-500 mb-4">Sorry, the page you're trying to access is restricted.</p>

    <?php if (isset($userId)) : ?>
        <a href="<?= uri() . '/' . $activeApp ?>" title="Go to dashboard">Go to dashboard</a>
    <?php else : ?>
        <a href="<?= uri() ?>" title="Go to home page">Go to home page</a>
    <?php endif ?>
</div>