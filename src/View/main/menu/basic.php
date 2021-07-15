<?php /** @var array $localizationData fetched from controller, contains translations of various UI and content parts */?>

<div class="settings" id="settings-basic">
    <button class="settings__button settings__button--green" id="enable-all-cookies" onclick="setCookieConsent('enable')"><?=$localizationData['enable-all-cookies']?></button>
    <button class="settings__button settings__button--red" id="the-dickhead-cookie-option" onclick="revokeCookieConsent()"><?=$localizationData['turn-off-banner-cookie']?></button>
    <button class="settings__button settings__button--red" id="conceal-menu-button" onclick="concealSettingsMenu()"><?=$localizationData['close']?></button>
</div>