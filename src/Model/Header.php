<?php

namespace App\Model;


class Header extends DefaultHeader
{
    /**
     * Header constructor.
     *
     * @param        $title
     * @param string $keywords
     * @param bool   $descriptionChange
     * @param string $robots
     * @param bool   $meta
     */
    public function __construct($title, $keywords = '', $descriptionChange = false, $robots = 'none', $meta = false)
    {
        //get the default description or meta
        if (!$this->description || !$meta)
            parent::__construct();
        
        $this->setTitle($title);
        $this->setKeywords($keywords);
        $this->setDescription($descriptionChange);
        $this->setRobots($robots);
        $this->setMeta($meta);
        
        if (isset($this->meta[0][0]) && $this->meta[0][0] === 'og:description' && $this->meta[0][1] === null){
            $this->meta[0][1] = $this->description;
        }
    }
    
    /**
     * @return string
     */
    public function getRobots(): string
    {
        return $this->robots;
    }
    
    /**
     * @param string $robots
     */
    public function setRobots(string $robots): void
    {
        $this->robots = $robots;
    }
    
    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
    
    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
    
    /**
     * @param array|bool $meta
     *
     * og:description should come first
     */
    public function setMeta($meta): void
    {
        if ($meta)
            $this->meta = $meta;
    }
    
    /**
     * @return string
     */
    public function getMeta(): string
    {
        return $this->meta;
    }
    
    /**
     * @return string
     */
    public function getKeywords(): string
    {
        return $this->keywords;
    }
    
    /**
     * @param string|null $keywords
     */
    public function setKeywords($keywords): void
    {
        $this->keywords = $keywords ?? '';
    }
    
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
    
    /**
     * @param string|bool $description
     */
    public function setDescription($description): void
    {
        if ($description)
            $this->description = $description;
    }
    
    public function writeMicrodata()
    {
        if ($this->meta) {
            echo '<meta name="twitter:card" content="summary" /><meta name="twitter:creator" content="@morgosus" />';
            foreach ($this->meta as $meta): ?>
                <meta property="<?= $meta[0] ?>" content="<?= $meta[1] ?>" />
            <?php endforeach;
        }
    }
}