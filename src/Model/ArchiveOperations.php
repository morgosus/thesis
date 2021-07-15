<?php

namespace App\Model;

use PDO;

class ArchiveOperations
{
    private $db;
    
    public function __construct($handler)
    {
        $this->db = new Db($handler);
    }
    
    /**
     * Display articles and sections by category name
     *
     * ANY CATEGORIES
     *
     * @param string $link
     *
     * @return Topic|false
     */
    public function stringLinkAccess($link)
    {
        return $this->db->fetchOneClass(
            'SELECT topic.id_topic, title, link
                  FROM topic
                  WHERE link = ? AND langcode = ?',
            [$link, LocaleAM::code()], 'Topic'
        );
    }
    
    
    /**
     * @return array
     */
    public function archiveRoot()
    {
        $categories = $this->db->fetchAllClass(
            'SELECT topic.id_topic, topic.title, topic.link,
                  (SELECT COUNT(*) FROM topic t3 JOIN topic t ON t3.id_topic = t.id_topic WHERE t.public = 1 AND t.parent = t2.id_topic AND t2.langcode = t2.langcode) AS \'countSubs\',
                  (SELECT COUNT(*) FROM article t4 JOIN article a ON t4.id_article = a.id_article WHERE a.public = 1 AND a.id_topic = t2.id_topic AND t4.langcode = t2.langcode) AS \'countArticles\'
                  FROM topic
                  JOIN topic t2 ON topic.id_topic = t2.id_topic
                  WHERE t2.parent IS NULL AND t2.langcode = ?
                  AND t2.public = 1',
            [LocaleAM::code()], 'Topic'
        );
        
        foreach ($categories as &$category) {
            $category->preview = $this->db->select(
                'SELECT * FROM publicArticles WHERE id_topic = ? AND id_language = ? LIMIT 1',
                [$category->id_topic, LocaleAM::code()]
            );
            
            $category->countSubs = $this->db->select(
                'WITH RECURSIVE topicsUnderTopic AS (
	                  SELECT * FROM topic WHERE parent = ?
                      UNION
                      SELECT children.*
                      FROM topic AS children, topicsUnderTopic AS thisWholeThing
                      WHERE children.parent = thisWholeThing.id_topic
                      ) SELECT COUNT(*) AS subCount FROM topicsUnderTopic;',
                [$category->id_topic]
            )['subCount'];
            
            $category->countArticles = $this->db->select(
                'WITH RECURSIVE articlesUnderTopic AS (
                	  SELECT * FROM topic WHERE id_topic = ?
                	  UNION
                	  SELECT children.*
                	  FROM topic AS children, articlesUnderTopic AS thisWholeThing
                	  WHERE children.parent = thisWholeThing.id_topic
                	  ) SELECT COUNT(*) AS articleCount FROM article WHERE id_topic IN (SELECT id_topic FROM articlesUnderTopic);',
                [$category->id_topic]
            )['articleCount'];
        }
        
        $articles = $this->db->fetchAllClass(
            'SELECT *
                  FROM articles
                  WHERE articles.id_topic IS NULL
                  AND id_language = ?',
            [LocaleAM::code()], 'Article'
        );
        
        return [$categories, $articles];
    }
    
    /**
     * Display articles and sections by id_category
     *
     * ONLY PUBLIC CATEGORIES
     *
     * @param string $id_category
     * @return Topic|false
     */
    public function numericLinkAccess($id_category)
    {
        return $this->db->fetchOneClass(
            'SELECT topic.id_topic, title AS \'name\', link
                  FROM topic
                  WHERE topic.id_topic = ? AND langcode = ?
                  AND public = 1',
            [$id_category, LocaleAM::code()], 'Topic'
        );
    }
    
    
    public function getRootSupercategories()
    {
        return [];
    }
    
    /**
     * Returns an array of parent category and then the previous ones
     * in the following format:
     *
     * [[0] => university-related, [1] => applied-mathematics]
     *
     * @param PDO $handler
     *
     * @return void
     */
    public function getCategories($handler)
    {
    
    }
    
    public function getCategoryCount() { }
}