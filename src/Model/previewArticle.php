<?php

namespace App\Model;

class PreviewArticle implements FetchClass
{
    public
        $id_article_translated,
        $id_article,
        $id_topic,
        $title,
        $id_user,
        $code,
        $link,
        $name, //image
        $src, //image
        $content,
        $digest,
        $keywords,
        $next, $username,
        $previous, $wordcount,
        $creation, $creationIso8601,
        $modified, $modifiedIso8601;
    
    /**
     * Article constructor.
     *
     */
    public function __construct()
    {
        //Time format and ordinal suffix
        if (LocaleAM::code() === 'cs-cz') {
            setlocale(LC_TIME, 'cs_CZ.UTF-8');
            $format = '%e. %B %G';
        } else {
            setlocale(LC_TIME, 'en_US.UTF-8');
            $format = '%e%O %B %G';
        }
        
        //Convert SQL timestamp to day.⎵month-name⎵year
        $this->creationIso8601 = $this->creation;
        
        $timestamp = strtotime($this->creation);
        $format = str_replace('%O', date('S', $timestamp), $format);
        
        $this->creation = strftime($format, $timestamp);
        
        if (isset($this->modified)) {//To prevent setting modified to 1970
            $this->modifiedIso8601 = $this->modified;
            
            $timestamp = strtotime($this->modified);
            $format = str_replace('%O', date('S', $timestamp), $format);
            
            $this->modified = strftime($format, $timestamp);
        }
    }
    
    public function readingTime()
    {
        return round($this->wordcount / 200);
    }
    
    /**
     * Returns true if the exists, false if not
     *
     * @return bool
     */
    public function exists()
    {
        if (isset($this->id_article))
            return true;
        return false;
    }
}