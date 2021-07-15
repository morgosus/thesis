<?php /** @var array $localizationData fetched from controller, contains translations of various UI and content parts */

if(!isset($_COOKIE['consent']) || $_COOKIE['consent'] === 'consent'): ?>
<section class="banner" id="cookie-banner">
    <h2 class="banner__title"><?= $localizationData['eu-title'] ?></h2>
    <p class="banner__text"><?= $localizationData['banner-content'] ?></p>
    <div class="banner__buttons">
    <button class="banner__button banner__button--red"
            onclick="this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode);"><?= $localizationData['banner-no'] ?>
    </button>
    <button class="banner__button" onclick="window.location = '/<?=$_SESSION['localization']->code?>/legal/cookies'">Cookie policy</button>
    <button class="banner__button" onclick="setCookieConsent('consent')"><?= $localizationData['banner-only-banner'] ?></button>
    <button class="banner__button banner__button--green" id="enable-all-cookies" onclick="setCookieConsent('enable')"><?= $localizationData['banner-enable'] ?></button>
    </div>
</section>
<script>
    let cookieBanner = document.getElementById('cookie-banner');
    let settingsButton = document.getElementById('settings-button');

    if (getCookie('consent') === 'enable') {
        cookieBanner.parentNode.removeChild(cookieBanner);
        let basicMenu = document.getElementById('settings-basic');
        if(basicMenu) {
            basicMenu.parentNode.removeChild(basicMenu);
        }
    } else if (getCookie('consent') === 'consent') {
        let advancedMenu = document.getElementById('settings');
        if(advancedMenu){
            advancedMenu.parentNode.removeChild(advancedMenu);
        }
        cookieBanner.parentNode.removeChild(cookieBanner);
        document.getElementById('settings-button').setAttribute('onclick', 'displaySimpleMenu()');
    } else {
        settingsButton.parentNode.removeChild(settingsButton);
    }
</script>
<?php endif; ?>