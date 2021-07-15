<?php

namespace App\Controller;

use App\Model\LocaleAM;

class AboutController extends Controller
{
    /**
     * Main processing body of the Controller
     *
     * @param $parameters
     * @return void
     */
    function process($parameters)
    {
        $this->localize('about');
        
        
        
        $this->setHeaders('Martin Toms', 'Martin Toms, toms.click', $this->data['localizationData']['about-me'], 'all', [
                ['og:description', $this->data['localizationData']['about-me']],
                ['og:url', 'https://www.toms.click' . $_SERVER['REQUEST_URI']],
                ['og:type', 'website'],
                ['og:site_name', 'Toms.click'],
                ['og:title', 'Martin Toms | Toms.click'],
                ['og:image', 'https://www.toms.click/src/View/image/anubite-preview.png'],
                ['og:locale', LocaleAM::code()]
            ]
        );
        
        
        
        $this->view = '_latte/about';
    }
}