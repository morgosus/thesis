<?php /** @var array $localizationData fetched from controller, contains translations of various UI and content parts */

if ($this->controller->headerAndFooter): ?>
<footer id="footer" class="footer">
    <div class="footer__copyright" id="copyright"><a href="#top-anchor">Back To Top</a></div>
    <ul class="footer__navigation">
        <li class="footer__button"><a class="footer__button-link" href="/<?= $_SESSION['localization']->code ?>/<?= $localizationData['terms-of-service'][0]?>"><?= $localizationData['terms-of-service'][1] ?></a></li>
        <li class="footer__button"><a class="footer__button-link" href="/<?= $_SESSION['localization']->code ?>/<?= $localizationData['privacy-policy'][0]?>"><?= $localizationData['privacy-policy'][1] ?></a></li>
        <li class="footer__button"><a class="footer__button-link" href="/<?= $_SESSION['localization']->code ?>/<?= $localizationData['cookies'][0] ?>"><?= $localizationData['cookies'][1] ?></a></li>
        <li class="footer__button"><a class="footer__button-link" href="/<?= $_SESSION['localization']->code ?>/legal/disclaimer">Disclaimer</a></li>
        <li class="footer__button"><a class="footer__button-link" href="/sitemap.xml">Sitemap</a></li>
    </ul>
    <div class="footer__copyright">© 2020 Martin Toms <span class="processing-time" id="processing-time"></span> <span class="processing-time" id="cache-information"><?=$localizationData['generated-just-now']?></span></div>
</footer>
<?php endif; ?>
<script type="application/ld+json">
  {
    "@context": "http://schema.org",
    "@type": "Organization",
    "name": "Toms.click",
    "url": "https://www.toms.click",
    "address": "",
    "sameAs": [
      "https://www.facebook.com/morgosus",
      "https://twitter.com/Morgosus",
      "https://www.instagram.com/morgosus",
      "https://www.linkedin.com/in/martin-toms-13ab80182/"
    ]
  }
</script>