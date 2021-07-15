<?php

namespace App\Controller;

use App\Model\Db;

class AdminController extends Controller
{
    /** @var Db $db */
    private $db;
    
    /**
     * Main processing body of the Controller
     *
     * @param array $parameters
     * @return void
     */
    public function process($parameters)
    {
        $this->permissions();
        
        $this->db = new Db($this->handler);
        
        $this->posts();
        
        $this->setHeaders('Admin');
        
        
        
        switch ($parameters[0] ?? null) {
            case 'comment-approval':
                $this->commentApproval();
                break;
            default:
                $this->articleEditor();
        }
    }
    
    private function permissions()
    {
        if ($_SESSION['user']->id_user !== '1') {
            $this->redirect('notice/401-unauthorized');
        }
    }
    
    private function articleEditor()
    {
        $visibleArticles = $this->db->select('SELECT id_article, title FROM articles ORDER BY title', [], true);
        $hiddenArticles = $this->db->select('SELECT id_article, title FROM hiddenArticles ORDER BY title', [], true);
        $images = $this->db->select('SELECT * FROM image', [], true);
        
        $this->setData(['visibleArticles', 'hiddenArticles', 'images'], [$visibleArticles, $hiddenArticles, $images]);
        
        
        
        $this->view = 'module/admin/editor';
    }
    
    private function posts()
    {
        if ($this->posted('approve') && $this->posted('id_comment')) {
            foreach ($_POST['id_comment'] as $id_comment) {
                $this->db->modify('UPDATE comment SET approved = 1 WHERE id_comment = ?', [$id_comment]);
            }
            
            $this->refresh();
        } elseif ($this->posted('reject')) {
            foreach ($_POST['id_comment'] as $id_comment) {
                $this->db->modify('UPDATE comment SET approved = -1 WHERE id_comment = ?', [$id_comment]);
            }
            
            $this->refresh();
        }
        
        
        if ($this->gotten('select') && $this->gotten('id_article_translated')) {
            
            $article = $this->db->select('SELECT * FROM articles WHERE id_article = ?', [$_GET['id_article_translated']]);
            
            if ($article === false) {
                $article = $this->db->select('SELECT * FROM hiddenArticles WHERE id_article = ?', [$_GET['id_article_translated']]);
                if ($article === false) {
                    $this->redirect('notice/failure');
                }
            }
            
            $this->data['toEdit'] = $article;
        }
        
        if ($this->posted('save') && $this->posted('title') && $this->posted('content') &&
            $this->posted('digest') && $this->posted('keywords') && $this->posted('link') &&
            $this->posted('id_article_translated')) {
            
            $this->db->modify(
                'UPDATE article
                      SET title = ?, content = ?, digest = ?, keywords = ?, link = ?
                      WHERE id_article = ?',
                [$_POST['title'], $_POST['content'], $_POST['digest'], $_POST['keywords'],
                    $_POST['link'], $_POST['id_article_translated']]);
            
            $this->refresh();
        }
        
        if ($this->posted('delete'))
            $this->refresh();
        
    }
    
    private function commentApproval()
    {
        $comments = $this->db->select(
            'SELECT c.id_comment, c.name, c.content, a.title, FALSE AS "duplicate" FROM comment c
                  JOIN articles a ON c.id_article = a.id_article
                  WHERE approved IS NULL', [], true);
        
        $sortedComments = [];
        
        foreach ($comments as $comment) {
            if (isset($sortedComments[$comment['title']])) {
                array_push($sortedComments[$comment['title']], $comment);
            } else $sortedComments[$comment['title']] = [$comment];
        }
        
        foreach ($sortedComments as &$article) {
            foreach ($article as &$comment) {
                for ($i = 0; $i < count($article); $i++) {
                    if ($comment['id_comment'] !== $article[$i]['id_comment'] && $comment['content'] === $article[$i]['content']) {
                        $article[$i]['duplicate'] = true;
                        $comment['duplicate'] = true;
                    }
                }
            }
        }
        
        
        
        $this->setData(['comments'], [$sortedComments]);
        $this->data['comments'] = $sortedComments;
        
        
        
        $this->view = 'module/admin/comment-approval';
    }
}