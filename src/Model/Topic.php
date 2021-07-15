<?php

namespace App\Model;

use PDO;

class Topic implements FetchClass
{
    public
        $id_topic,
        $title,
        $link,
        $nameParsed,
        $parent,
        $description,
        $citation,
        $public,
        $articleCount,
        $preview,
        $countSubs, $countArticles;
    
    /** @var Db $db */
    private $db;
    
    /**
     * Topic constructor.
     *
     * @param null $id_topic
     * @param null $name
     * @param null $parent
     * @param PDO  $handler
     */
    public function __construct($id_topic = null, $name = null, $parent = null, $handler = null)
    {
        //In case of a parameterless access
        if (isset($id_topic)) {
            $this->id_topic = $id_topic;
            $this->title = $name;
            $this->parent = $parent;
            $this->connectDb($handler);
        }
    }
    
    public function connectDb($handler)
    {
        $this->db = new Db($handler);
    }
    
    public function getArticles()
    {
        return $this->db->fetchAllClass(
            'SELECT link, title, digest, name, src
                  FROM articles
                  WHERE id_topic = ? AND id_language = ?',
            [$this->id_topic, LocaleAM::code()], 'Article'
        );
    }
    
    public function getSubcategories()
    {
        $categories = $this->db->fetchAllClass(
            'SELECT t2.id_topic, t2.title, t2.link,
                  (SELECT COUNT(*) FROM topic t3 JOIN topic t ON t3.id_topic = t.id_topic WHERE t.public = 1 AND t.parent = t2.id_topic AND t3.langcode = t2.langcode) AS \'countSubs\',
                  (SELECT COUNT(*) FROM article t4 JOIN article a ON t4.id_article = a.id_article WHERE a.public = 1 AND a.id_topic = t2.id_topic AND t4.langcode = t2.langcode) AS \'countArticles\'
                  FROM topic
                  JOIN topic t2 ON topic.id_topic = t2.id_topic
                  WHERE t2. parent = ?
                  AND t2.public = 1 AND t2.langcode = ?',
            [$this->id_topic, LocaleAM::code()], 'Topic'
        );
        
        foreach ($categories as &$category) {
            $category->preview = $this->db->select(
                'SELECT * FROM publicArticles WHERE id_topic = ? AND id_language = ? LIMIT 1',
                [$category->id_topic, LocaleAM::code()]
            );
        }
        
        return $categories;
    }
    
    public function articleCount()
    {
        $this->articleCount = $this->db->select(
            'SELECT COUNT(*) FROM article
                  WHERE id_topic = ? AND langcode = ?', [
            $this->id_topic, LocaleAM::code()
        ]);
        
        return $this->articleCount;
    }
    
    public function getSupercategories()
    {
        if ($this->id_topic === null) {
            return false;
        }
        
        $categories = [];
        $idCategory = $this->id_topic;
        do {
            //Get current category
            
            $category = $this->db->select(
                'SELECT topic.id_topic AS id, link AS link, title AS name, parent AS parent FROM topic
                 WHERE topic.id_topic = ?', [$idCategory]);
            
            //Prepare
            $idCategory = $category['parent'];
            
            //Add it to our array
            array_push($categories, $category['name'] . '_' . $category['link']);
            //} while ($idCategory !== null);
        } while (isset($idCategory));
        
        return array_reverse($categories);
    }
    
    /**
     * Returns true if the exists, false if not
     *
     * @return bool
     */
    public function exists()
    {
        if (isset($this->id_topic))
            return true;
        else
            return false;
    }
}