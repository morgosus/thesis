<?php /** @var array $localizationData fetched from controller, contains translations of various UI and content parts
        * @var string $pageName name of the currently displayed page */
if ($this->controller->headerAndFooter): ?>
<header class="header" id="top-anchor">
    <div class="header__top-wrapper">
        <div class="header__upper-part">
        <div id="logo" class="logo navigation__category"><a href="/">Toms.click</a></div>
    
        <div class="search">
            <!--suppress JSUndefinedPropertyAssignment -->
            <input class="search__searchbar" tabindex="1" id="search"
                   onfocus="this.placeholder = ''"
                   onfocusout="this.placeholder = 'Search'"
                   oninput="document.getElementById('search-button').disabled = false; document.getElementById('search-button').style.display = 'inline-block'; document.getElementById('search-button').style.cursor = 'pointer'"
            type="search" placeholder="<?=$localizationData['search'][1]?>">
            <!--suppress JSUndefinedPropertyAssignment -->
            <button title="Search button" class="search__button" tabindex="2" id="search-button"
                    onclick="search(); document.getElementById('search').value = ''; this.disabled = true" disabled></button>
            <button title="Menu button" id="settings-button" onclick="displaySettingsMenu()">≡</button>
            <button id="settings-button-fake" class="hidden" onclick="location.reload()">⟳</button>
        </div>
        </div>
    </div>
    
    <nav id="navigation" class="navigation navigation--collapsed">
        <div id="home-icon" class="navigation__category<?= ($pageName === 'homepage' || $pageName === 'domovska-stranka')?' active':null ?>"><a class="navigation__category-link" href="/<?= $_SESSION['localization']->code ?>">⌂</a></div>
        <div id="home-button" class="navigation__category"><a class="navigation__category-link" href="/<?= $_SESSION['localization']->code ?>"><?=($_SESSION['localization']->id === 2)?'Domů':'Home' ?></a></div>
        <div id="archive-button" class="navigation__category<?= ($pageName === 'archive' || $pageName === 'archiv')?' active':null ?>"><a class="navigation__category-link" id="archive-button-link" href="/<?= $_SESSION['localization']->code ?>/<?= $localizationData['archive'][0]?>"><?= $localizationData['archive'][1] ?></a></div>
        <div id="about-button" class="navigation__category<?= ($pageName === 'about' || $pageName === 'o-nas')?' active':null ?>"><a class="navigation__category-link" id="about-button-link" href="/<?= $_SESSION['localization']->code ?>/<?=$localizationData['about'][0]?>"><?= $localizationData['about'][1] ?></a></div>
        <div id="other-button" class="navigation__category navigation__category--middle-one"><a class="navigation__category-link" id="other-button-link" href="<?= $_SERVER['REQUEST_URI'] ?>">This</a></div>
    
        <?php
        if(($_COOKIE['consent'] ?? false) === 'enable')
            include __DIR__ . '/menu/complete.php';
        elseif (($_COOKIE['consent'] ?? false) === 'consent')
            include __DIR__ . '/menu/basic.php';
        
        $uri = explode('?', substr($_SERVER['REQUEST_URI'], 7))[0];
        ?>
        
        <div id="languages" class="languages">
            <a hreflang="cs" href="/en-us/<?=$uri?>" id="en-us" class="languages__flag languages__flag--en-us" title="Change language to English. (Změnit jazyk na Angličtinu.)">
            </a>
            <a hreflang="en" href="/cs-cz/<?=$uri?>" id="cs-cz" class="languages__flag languages__flag--cs-cz" title="Změnit jazyk na Češtinu. (Change language to Czech.)">
            </a>
        </div>
    </nav>
</header>
<?php endif; ?>