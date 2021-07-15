<?php

namespace App\Model;


class DefaultHeader
{
    protected $robots = 'none';
    protected $title = '';
    /** @var array|bool $meta */
    protected $meta;
    protected $keywords = '';
    protected $description;
    
    public function __construct($generateDescription = true, $generateMeta = true)
    {
        if ($generateDescription) {
            $translate = new LocalizationDictionary();
            $this->description = $translate->defaultDescription();
        }
        
        if ($generateMeta) {
            $this->meta = [
                ['og:url', 'https://www.toms.click' . $_SERVER['REQUEST_URI']],
                ['og:type', 'website'],
                ['og:site_name', 'Toms.click'],
                ['og:title', 'Toms.click'],
                ['og:image', 'https://www.toms.click/src/View/image/anubite-preview.png'],
                ['og:locale', LocaleAM::code() ?? 'en-us'],
                ['og:description', $this->description]
            ];
        }
    }
    
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
    
    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
    
    /**
     * @return string
     */
    public function getRobots(): string
    {
        return $this->robots;
    }
    
    /**
     * @return string
     */
    public function getKeywords(): string
    {
        return $this->keywords;
    }
    
    public function writeMicrodata()
    {
        echo '<meta name="twitter:card" content="summary" /><meta name="twitter:creator" content="@morgosus" />';
        foreach ($this->meta as $meta): ?>
            <meta property="<?= $meta[0] ?>" content="<?= $meta[1] ?>" />
        <?php endforeach;
    }
    
}