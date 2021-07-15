<?php
/**
 * @var string $lang
 * @var array $localizationData
 */
?><!DOCTYPE HTML>
<html lang="<?= $lang ?>">
<?php require __DIR__ . "/head.php"; ?>

<!--TODO: Move the onscroll effect-->
<body onscroll="toggleBTT()">

<?php require __DIR__ . "/header.php"; ?>

<?php require __DIR__ . "/cookies.php" ?>

<?php require __DIR__ . "/main.php" ?>

<?php if ($this->controller->headerAndFooter): ?>
<a id="back-to-top" href="#top-anchor" onclick="toggleBTT(true)" title="<?= $localizationData['back-to-top'] ?>" class="sb hidden">↑</a>
<?php endif; ?>

<?php require __DIR__ . "/footer.php"; ?>

<script src="/src/Javascript/search.js?v=<?= FILE_VERSION ?>"></script>
<script src="/src/Javascript/btt-and-modes.js?v=<?= FILE_VERSION ?>"></script>

<?php require __DIR__ . '/active-tab-js.php' ?>


<?php require __DIR__ . '/caching-end.php' ?>