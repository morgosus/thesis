<?php

namespace App\Controller;


use App\Model\LocaleAM;

class LegalController extends Controller
{
    
    public function processParameterless()
    {
        $this->redirect('home');
    }
    
    function process($parameters)
    {
        
        switch ($parameters[0]) {
            case 'terms-of-service':
            case 'privacy-policy':
            case 'cookies':
            case 'credits':
            case 'disclaimer':
                $this->valid($parameters[0]);
                break;
            default:
                $this->notValid();
                break;
        }
    }
    
    private function valid($documentName)
    {
        $title = ucwords(str_replace('-', ' ', $documentName));
        
        
        
        $this->setHeaders(
            $title,
            'legal document',
            $title,
            'index,nofollow',
            [
                ['og:url', 'https://www.toms.click' . $_SERVER['REQUEST_URI']],
                ['og:type', 'website'],
                ['og:site_name', 'Toms.click'],
                ['og:title', $title . ' | Toms.click'],
                ['og:image', 'https://www.toms.click/src/View/image/anubite-preview.png'],
                ['og:locale', LocaleAM::code()],
                ['og:description', $title]]
        );
        
        
        
        $this->view = '_latte/legal/' . $documentName;
        
    }
    
    private function notValid()
    {
        $this->redirect('notice/404-article-not-found');
        exit;
    }
}