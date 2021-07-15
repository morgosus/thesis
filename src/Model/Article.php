<?php

namespace App\Model;

use cebe\markdown\MarkdownExtra;
use PDO;

class Article implements FetchClass
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
        $keywords, $audio,
        $next, $username,
        $previous, $wordcount,
        $creation, $creationIso8601,
        $modified, $modifiedIso8601,
        $difference;
    
    /**
     * Article constructor.
     *
     */
    public function __construct()
    {
        LocaleAM::setLocale();
        
        //Convert SQL timestamp to day.⎵month-name⎵year
        $this->creationIso8601 = $this->creation;
        
        //$timeOld = new \DateTime($this->creationIso8601);
        //$this->difference = $timeOld->diff(new \DateTime(), true);
        
        
        $this->difference = LocaleAM::timeDifference($this->creationIso8601);
        
        $timestamp = strtotime($this->creation);
        $format = str_replace('%O', date('S', $timestamp), LocaleAM::format());
        
        $this->creation = strftime($format, $timestamp);
        
        if (isset($this->modified)) {//To prevent setting modified to 1970
            $this->modifiedIso8601 = $this->modified;
            
            $this->modified = strftime($format, strtotime($this->modified));
        }
    }
    
    public function parseContent()
    {
        $parser = new MarkdownExtra();
        $this->content = $parser->parse($this->content);
        $this->content = preg_replace('/(<\/h\d>\n)<p>/', '$1<p class="after-title">', $this->content);
    }
    
    /**
     * Returns an array of parent category and then the previous ones
     * in the following format:
     *
     * [[0] => university-related, [1] => applied-mathematics]
     *
     * @param PDO $handler
     *
     * @return array|false
     */
    public function getCategories($handler)
    {
        if ($this->id_topic === null) {
            return false;
        }
        
        $categories = [];
        $idCategory = $this->id_topic;
        do {
            //Get current category
            $db = new Db($handler);
            
            $category = $db->select(
                'SELECT topic.id_topic AS id, langcode, link AS link, title AS name, parent AS parent FROM topic
                 WHERE topic.id_topic = ?', [$idCategory]);
            
            //Prepare
            $idCategory = $category['parent'];
            
            //Add it to our array
            array_push($categories, $category['name'] . '_' . $category['link'].$category['langcode']);
            //} while ($idCategory !== null);
        } while (isset($idCategory));
        
        return array_reverse($categories);
    }
    
    /**
     * Returns an array of article previews from the same category
     *
     * @param PDO $handler
     *
     * @return array|false
     */
    public function getRelatedPreviews($handler)
    {
        $db = new Db($handler);
        
        return $db->fetchAllClass(
            'SELECT title, link, src, name
                  FROM publicArticles
                  WHERE id_article != ? AND id_topic = ? AND id_language = ?
                  ORDER BY RAND()
                  LIMIT 3',
            [
                $this->id_article,
                $this->id_topic,
                LocaleAM::code()
            ], 'Article'
        );
    }
    
    /**
     * Returns the preview of next or previous article of a series
     *
     * @param     $previousOrNext
     * @param PDO $handler
     *
     * @return Article|false
     */
    public function getRelatedPreview($previousOrNext, $handler)
    {
        if ($previousOrNext === null) {
            return false;
        }
        
        $db = new Db($handler);
        
        if ($previousOrNext === 'next') {
            return $db->select('SELECT title, link, src, name FROM articles WHERE id_article = (SELECT next FROM article WHERE article.id_article = ?) AND id_language = ?', [$this->id_article, LocaleAM::code()]);
        } else {
            return $db->select('SELECT title, link, src, name FROM articles WHERE next = ? AND id_language = ?', [$this->id_article, LocaleAM::code()]);
        }
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
        else
            return false;
    }
    
    public function countWords()
    {
        //TODO: Implement
    }
    
    public function readingTime()
    {
        return round($this->wordcount / 200);
    }
}