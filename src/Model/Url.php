<?php

namespace App\Model;

class Url
{
    private $parameters, $lang, $id, $subpageName;
    
    /**
     * Url constructor
     *
     * @param string $parameters "/par1/par2/par3"
     */
    public function __construct($parameters) {
        $this->parameters = $parameters;
    }
    
    /**
     * $parsedURL[0] ... Controller name → ExampleController
     * $parsedURL    ... Controller name + parameters
     *
     * @return array
     */
    public function parseForRouter()
    {
        $parsing = ltrim($this->parameters, '/');
        
        $parsing = trim($parsing);
        
        $parsedURL = explode('/', $parsing);
        
        $lastIndex = count($parsedURL) - 1;
        
        //Fun fact: Without this, anything with a GET string would throw 404
        $parsedURL[$lastIndex] = strtok($parsedURL[$lastIndex], '?');
        
        if (isset($parsedURL[1])) {
            $parsedURL[1] = ucfirst($parsedURL[1]);
            
            $parsedURL[1] .= 'Controller';
        } else {
            $parsedURL[1] = 'none';
        }
        
        
        
        $this->lang = substr($parsedURL[0], 0, 2);
        $this->id = strtolower(str_replace('Controller', '', ($parsedURL[1] !== '') ? $parsedURL[1] : 'homepage'));
        $this->subpageName = $parsedURL[2] ?? null;
        
        
        return $parsedURL;
    }
    
    public function getLang()
    {
        return $this->lang;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getPageName()
    {
        return $this->getId();
    }
    
    public function getSubpageName()
    {
        return $this->subpageName;
    }
}
