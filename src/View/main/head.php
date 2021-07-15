<head>
    <meta charset="utf-8">
    
    <?php include __DIR__ . '/meta.php'; ?>
    
    <link rel="stylesheet" type="text/css" href="/src/View/css/reset.css?v=<?= FILE_VERSION ?>">
    
    <link id="animation-stylesheet" rel="stylesheet" type="text/css" href="/src/View/css/animations.css?v=<?= FILE_VERSION ?>">
    
    <link rel="stylesheet" type="text/css" href="/src/View/sass/cheeky.css?v=<?= FILE_VERSION ?>">
    
    <link id="black-and-white-stylesheet" rel="stylesheet" type="text/css" href="/src/View/sass/black-and-white.css?v=<?= FILE_VERSION ?>" disabled>
    
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    
    <link rel="icon" href="/public/favicon.ico" type="image/x-icon" />
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <script src="/src/Javascript/master.js?v=<?= FILE_VERSION ?>"></script>
    
    <!--suppress JSUnusedLocalSymbols -->
    <script>
        const localizationCode = '<?=$_SESSION['localization']->code?>';
        const localizationId = '<?=$_SESSION['localization']->id?>';
    </script>
    
    <?php include __DIR__ . "/google-analytics.php"; ?>


</head>