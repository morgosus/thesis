<?php

namespace App\Model;

/**
 * Class Caching Operations
 *
 * @var string $url         The original URL that is to be cached
 * @var string $cacheFolder A folder where cache files are saved
 * @var string $cacheFile   The file into which a particular cache is saved
 * @var int    $cacheTime   Time for which the cache is valid
 * @var string $extension   The file extension of the $cacheFile
 *
 * @package App\Model
 */
class CachingOperations
{
    private $url, $cacheFolder, $cacheFile, $cacheTime;
    private $extension = '.php';
    
    public function __construct($folder, $time)
    {
        $this->cacheFolder = $folder;
        $this->cacheTime = $time;
        
        $this->saveUrl();
        
        $this->makeCacheFileName();
    }
    
    private function saveUrl()
    {
        $uri = explode('?', $_SERVER['REQUEST_URI']);
        
        $this->url = 'https://' . $_SERVER['HTTP_HOST'] . $uri[0];
    }
    
    /**
     * @return string which is included in the cache file
     */
    private function cacheStamp()
    {
        $time = date('Y-m-d h:i:s A', filemtime($this->cacheFile));
        $timeTaken = MicroDataOperations::getDifference();
        
        return <<<CACHE_SCRIPT
            <script>
                let cacheInformation = "Cache: $time";
                document.getElementById('cache-information').innerHTML = cacheInformation;
                document.getElementById("processing-time").innerHTML = "$timeTaken"
             </script></body></html>
CACHE_SCRIPT;
    }
    
    /**
     *  File needs to be unique for each URL.
     */
    private function makeCacheFileName()
    {
        $this->cacheFile = $this->cacheFolder . md5($this->url) . $this->extension;
    }
    
    /**
     * If it does, we'll want to use it.
     *
     * @return bool
     */
    public function validCacheExists()
    {
        return file_exists($this->cacheFile) && time() - $this->cacheTime < filemtime($this->cacheFile);
    }
    
    /**
     *  Reads and includes a cached page.
     */
    public function readCache()
    {
        ob_start();
        
        include($this->cacheFile);
        
        echo $this->cacheStamp();
        
        ob_end_flush();
        exit();
    }
    
    /**
     * Getter for the cache file's name.
     *
     * @return string
     */
    public function nameTheCache()
    {
        return $this->cacheFile;
    }
    
    /**
     *  Creates a cache file.
     */
    public function cacheThisPage()
    {
        if (!is_dir($this->cacheFolder))
            mkdir($this->cacheFolder);
        
        $fp = fopen($this->cacheFile, 'w');
        
        fwrite($fp, ob_get_contents());
        
        ob_end_flush();
        
    }
}