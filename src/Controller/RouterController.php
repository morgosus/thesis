<?php

namespace App\Controller;

use App\Model\CachingOperations;
use App\Model\LocaleAM;
use App\Model\LocalizationContainer;
use App\Model\Url;

class RouterController extends Controller
{
    public $controller;
    
    public $headers;
    
    public function process($REQUEST_URI)
    {
        $parsedUri = $this->parse($REQUEST_URI);
        
        $langcode = array_shift($parsedUri);
    
    
        $this->localization($langcode);
    
        $controllerName = array_shift($parsedUri);
        
        if (array_key_exists($controllerName, ROUTING_TABLE))
            $controllerName = ROUTING_TABLE[$controllerName];
        
        
        if ($controllerName === 'Controller' || $controllerName === 'none')
            $this->redirectToHomepage();
        
        $loc = __DIR__ . '/../Controller/' . $controllerName . '.php';
        
        file_exists($loc) ?
            $this->valid($controllerName, $parsedUri) :
            $this->invalid();
        
    }
    
    
    private function parse($parameters)
    {
        $URLOperations = new URL($parameters);
        
        //Transform domain/localization/controller/par1/par2 to an array [localization, controller, par1, par2]
        $parsedURL = $URLOperations->parseForRouter();
        
        $this->data['lang'] = $URLOperations->getLang(); //for html lang attribute
        $this->data['mainId'] = $URLOperations->getId(); //id="" of <main>
        $this->data['pageName'] = $URLOperations->getPageName(); //for javascript
        $this->data['subpageName'] = $URLOperations->getSubpageName(); //for javascript
        
        return $parsedURL;
    }
    
    private function localization($langcodeToCheck)
    {
        if (LocaleAM::notSetOrChanged($langcodeToCheck)){
            $this->useUrlLanguage($langcodeToCheck);
        }
    }
    
    private function checkCaching($page)
    {
        if (in_array($page, CACHED_ITEMS)) {
            
            $cacheFolder = __DIR__ . '/../../cache/';
            
            $co = new CachingOperations($cacheFolder, CACHE_TIME);
            
            
            if ($co->validCacheExists()) {
                $co->readCache();
            } else {
                
                $this->data['cachingOperations'] = $co;
                
                ob_start();
            }
        }
    }
    
    
    /**
     * Set localization based on URL, if you enter with /en-us, you'll be directed to /en-us from now on.
     * If you enter the domain with no localization in the URL, you'll be directed to one based on the browser.
     *
     * @param string $check
     */
    private function useUrlLanguage($check)
    {
        $accepting = ['en-us', 'cs-cz'];
        
        $code = in_array($check, $accepting) ? $check : null;
        
        if ($code === null)
            $this->useBrowserLanguage();
        else
            $_SESSION['localization'] = new LocalizationContainer($code);
    }
    
    /**
     * Set localization based on browser language / headers. If you enter with an English localization, you'll have
     * english
     */
    private function useBrowserLanguage()
    {
        $lang = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
        
        if ($lang === 'cs')
            $code = 'cs-cz';
        else
            $code = 'en-us';
        
        $_SESSION['localization'] = new LocalizationContainer($code);
    }
    
    /**
     * Any valid controller/page
     *
     * @param $controllerName
     * @param $parsedURL
     */
    private function valid($controllerName, $parsedURL)
    {
        if (CACHE_ENABLED) {
            $this->checkCaching($controllerName);
        }
        
        $controllerName = 'App\Controller\\' . $controllerName;
        
        $this->controller = new $controllerName($this->handler);
        
        if (isset($parsedURL[0])) {
            $this->controller->process($parsedURL);
        } else {
            $this->controller->processParameterless();
        }
        
        
        $this->localize('base');
        
        $this->view = 'main/base';
    }
    
    /**
     * Redirect to 404 with the URI in $_GET
     */
    private function invalid()
    {
        $this->redirect('notice/404-not-found?uri=' . $_SERVER['REQUEST_URI']);
    }
}
