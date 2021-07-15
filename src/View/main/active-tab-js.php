<?php /** @var string $pageName name of the currently displayed page */ ?>

<script>
    const pageName = '<?=$pageName?>';

    const subPageName = '<?=$subpageName ?? 'null'?>';

    let routingTable = {
        'recepce': 'homepage',
        'article': 'other',
        'clanek': 'other',
        'legal': 'other',
        'archiv': 'archive',
        'o-nas': 'about',
        'uzivazel': 'user'
    };

    let button;

    if (routingTable[pageName]) {
        button = document.getElementById(routingTable[pageName] + '-button');
    } else {
        if (pageName === 'homepage' || pageName === 'recepce' || pageName === 'domovska-stranka') {
            button = document.getElementById('home-icon');

        } else {
            button = document.getElementById(pageName + '-button');
        }
    }

    if (button) {
        if (subPageName !== 'null') {
            button = document.getElementById('other-button');
            button.classList.add('active');
            button.style.display = 'inline-block';

            //document.getElementById('other-button-link').innerHTML = document.title.substr(0, document.title.indexOf('|'));
            if (pageName === 'article' || pageName === 'clanek') {
                let first = document.title.indexOf(' | ') + 3;
                let second = document.title.indexOf(' | ', first + 1);
                document.getElementById('other-button-link').innerHTML = document.title.substr(first, second - first);
            }
            else
                document.getElementById('other-button-link').innerHTML = document.title.substr(0, document.title.indexOf('|'));
        } else {
            button.classList.add('active');
        }
    } else {
        button = document.getElementById('logo');
        button.classList.add('active');
    }
</script>