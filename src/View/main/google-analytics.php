<?php if (isset($_COOKIE['consent']) && $_COOKIE['consent'] === 'enable'): ?>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-175998459-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-175998459-1');
</script>
<?php endif; ?>