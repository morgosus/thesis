<?php

namespace App\Controller;

use App\Model\FetchOperations;
use App\Model\LocaleAM;

class HomepageController extends Controller
{
    /**
     * Main processing body of the Controller
     *
     * @param $parameters
     * @return void
     */
    function process($parameters)
    {
        $fetch = new FetchOperations($this->handler);
        
        
        
        $this->setData(
            ['newest', 'featured'],
            [$fetch->homepageArticles()[0], $fetch->homepageArticles()[1]],
            'homepage'
        );
        
        
        
        $this->setHeaders($this->data['localizationData']['title'], '', $this->data['localizationData']['description'], 'all', [
            ['og:description', $this->data['localizationData']['description']],
            ['og:url', 'https://www.toms.click' . $_SERVER['REQUEST_URI']],
            ['og:type', 'website'],
            ['og:site_name', 'Toms.click'],
            ['og:title', $this->data['localizationData']['title'] . ' | Toms.click'],
            ['og:image', 'https://www.toms.click/src/View/image/anubite-preview.png'],
            ['og:locale', LocaleAM::code()]
        ]);
        
        
        
        $this->view = 'homepage/base';
    }
}