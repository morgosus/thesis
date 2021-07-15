<?php

namespace App\Controller;

use App\Model\Db;
use App\Model\DefaultHeader;
use App\Model\Header;
use App\Model\LocaleAM;
use App\Model\LocalizationDictionary;
use Latte\Engine;
use PDO;

abstract class Controller
{
    /** @var array $data items to be extracted into variables for variables
     *
     * Usage example:
     * $this->data = ['foo' => 'bar', 'bar' => 'foo'] would produce two variables: $foo = 'bar' and $bar = 'foo';
     */
    protected $data = [];
    
    /** @var string $view output template name */
    protected $view = "";
    
    /** @var DefaultHeader|Header $header */
    protected $header;
    
    /** @var PDO $handler */
    protected $handler = null;
    
    protected $latteParameters = [];
    
    protected $headerAndFooter = true;
    
    /** @var Db $db */
    public function __construct($db = null)
    {
        if ($db !== null) {
            $this->handler = $db;
        }
        
        $this->header = new DefaultHeader();
        
        //Available within all .latte files as $langId, $langCode and $fv
        $this->latteParameters['langId'] = LocaleAM::id() ?? false; //integer 1 || 2
        $this->latteParameters['langCode'] = LocaleAM::code() ?? false; //string en-us || cs-cz
        $this->latteParameters['fv'] = FILE_VERSION; //number with decimals (1.393 at the time of writing)
    }
    
    /**
     * Main processing body of the Controller
     *
     * @param array $parameters
     * @return void
     */
    abstract public function process($parameters);
    
    /**
     * Main processing body of the Controller
     *
     * Works the same as process() by default
     *
     * @return void
     */
    public function processParameterless()
    {
        $this->process([]);
    }
    
    /**
     * For displaying the page, legacy .php templates
     */
    public function view()
    {
        $this->processParametersForView();
        
        if ($this->view === 'main/base') { //Legacy and body
            extract($this->data);
            
            include(__DIR__ . '/../View/' . $this->view . '.php');
            
            return;
        }
        
        //Templates
        $this->latteView();
    }
    
    protected function processParametersForView() {
    
    }
    
    /**
     * For displaying .latte templates
     */
    protected function latteView()
    {
        $latte = new Engine();
        
        try {
            $latte->render(__DIR__ . '/../View/' . $this->view . '.latte', $this->latteParameters);
        } catch (\RuntimeException $exception) {
            //File not found
            echo '[Error] Work in progress.';
        }
    }
    
    /**
     * For redirecting the user on the back-end
     *
     * @param string $url target URL
     */
    public function redirect($url)
    {
        header("Location: /" . LocaleAM::code() . "/$url");
        header("Connection: close");
        exit;
    }
    
    public function redirectToHomepage(){
        $this->redirect($this->localize('link-homepage'));
    }
    
    public function refresh()
    {
        header("Location: " . $_SERVER['REQUEST_URI']);
        header("Connection: close");
        exit;
    }
    
    protected function posted($index)
    {
        return (isset($_POST[$index]));
    }
    
    protected function gotten($index)
    {
        return (isset($_GET[$index]));
    }
    
    public function redirectToRoot()
    {
        header('Location: /');
        header('Connection: close');
        exit;
    }
    
    protected function localize($item)
    {
        $ld = new LocalizationDictionary();
    
        if (method_exists($ld, $item)) {
            //entire page
            $this->data['localizationData'] = $ld->$item();
            $this->latteParameters['localizationData'] = $ld->$item();
            return true;
        } else {
            //a piece of page
            return $ld->searchAndTranslate($item);
        }
    }
    
    protected function setRobots($robots = 'none')
    {
        $this->header['robots'] = $robots;
    }
    
    /**
     * @param string      $title    for the title tag
     * @param string|     $keywords for the meta keywords tag
     * @param bool|string $descriptionChange
     * @param string      $robots   for the robots meta tag
     * @param bool|array  $meta     accepts arrays of the following format:
     *                              ['og:url', 'https://www.example.com/' . $article->link],
     *                              ['og:site_name', 'example.com'],
     *                              ...
     *
     *                      and translates to
     *                      <meta property="og:url" content="https://www.example.com/some-link">
     *                      <meta property="og:site_name" content="example.com">
     *                      ...
     */
    protected function setHeaders($title, $keywords = '', $descriptionChange = false, $robots = 'none', $meta = false)
    {
        $this->header = new Header($title, $keywords, $descriptionChange, $robots, $meta);
    }
    
    /**
     * @param array       $indices
     * @param array       $data
     * @param null|string $pageNameForLocalization
     */
    protected function setData($indices, $data, $pageNameForLocalization = null)
    {
        foreach ($indices as $key => $index) {
            $this->latteParameters[$index] = $data[$key];
        }
        
        if (isset($pageNameForLocalization))
            $this->localize($pageNameForLocalization);
    }
    
    /**
     * For creating breadcrumbs, article, archive, etc.
     * Accepts an array of categories, subcategories or supercategories.
     *
     * @param array $categories
     * @param int   $type For some unholy reason, it's behaving differently for article and archive. I give up.
     *                    This fixes it. The issue is with breaking.
     * @return array
     */
    protected function breadcrumbs($categories, $type = 1)
    {
        
        $breadcrumbs = [];
        
        $langcode = substr($categories[0] ?? '',-5);
        
        $total = '/' . $langcode . '/' . ($this->localize('link-archive'));
        
        $count = count($categories);
        
        foreach ($categories as $key => $category) {
            $category = substr($category, 0, -5);
            
            if (($key == $count - 1 && $type === 1) || ($key == $count && $type === 2)) {
                break;
            }
            $category = explode('_', $category);
            $total .= '/' . $category[1];
            
            array_push($breadcrumbs, [$total, $category[0]]);
        }
        
        return $breadcrumbs;
    }
}
