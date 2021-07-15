<?php

namespace App\Model;


class FetchOperations
{
    private $db;
    
    public function __construct($handler)
    {
        $this->db = new Db($handler);
    }
    
    /**
     * @return array
     */
    public function homepageArticles()
    {
        return [
            $this->homepageGetNewestArticles(),
            $this->homepageGetFeaturedArticles()
        ];
    }
    
    /**
     * @return Article|false
     */
    private function homepageGetNewestArticles()
    {
        return $this->db->fetchAllClass(
            'SELECT * FROM publicArticles WHERE id_language = ? ORDER BY creation DESC LIMIT 14',
            [LocaleAM::code()], 'Article');
    }
    
    /**
     * @return Article|false
     */
    private function homepageGetFeaturedArticles()
    {
            return $this->db->fetchAllClass(
                'SELECT * FROM publicArticles WHERE id_language = ? ORDER BY RAND() LIMIT 5',
                [LocaleAM::code()], 'Article');
    }
    
    /**
     * @param string $link
     *
     * @return Article|false
     */
    public function article($link)
    {
        return $this->db->fetchOneClass(
            'SELECT * FROM articles WHERE link = ?', //Links are unique, no need to check the language
            [$link], 'Article');
    }
    
    public function comments($id_article)
    {
        $commentArray = [];
        
        $comments = $this->db->fetchAllClass(
            'SELECT * FROM comment WHERE id_article = ? AND approved > 0 ORDER BY creation, id_parent DESC',
            [$id_article], 'comment'
        );
        
        foreach ($comments as $comment) {
            if (isset($comment['id_parent'])) {
                //Put it after the comment with id_comment = id_parent
                //sort?
                //TODO: What if the parent has a parent? Make sure that doesn't happen for now (only insert comment if the parent has no parent - reply directs to parent)
                if (isset($commentArray[$comment['id_parent']])) {
                    array_push($commentArray[$comment['id_parent']], $comment);
                }
            } else {
                $commentArray[$comment['id_comment']] = [$comment];
            }
        }
        
        return $commentArray;
    }
}