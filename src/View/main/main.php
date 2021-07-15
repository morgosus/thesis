<?php /** @var string $mainId name of the currently displayed page converted to a class name */ ?>

<main class="main" id="<?= $mainId ?>">
    <?php include __DIR__.'/search-and-notify.php'?>
    <?= $this->controller->view(); ?>
</main>