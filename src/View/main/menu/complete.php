<?php /** @var array $localizationData fetched from controller, contains translations of various UI and content parts */ ?>

<div class="settings" id="settings">
    <button class="settings__button" id="contact-menu-button" onclick="window.location = 'https://contact.toms.click/'"><?=$localizationData['contact-me']?></button>

    <button class="settings__button settings__button--red" id="the-dickhead-cookie-option" onclick="revokeCookieConsent()"><?=$localizationData['turn-off-cookies']?></button>
    
    <button class="settings__button settings__button--red" id="conceal-menu-button" onclick="concealSettingsMenu()"><?=$localizationData['close']?></button>
</div>