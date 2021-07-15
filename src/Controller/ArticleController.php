<?php

namespace App\Controller;

use App\Model\Db;
use App\Model\FetchOperations;
use App\Model\LocaleAM;

class ArticleController extends Controller
{
    function processParameterless()
    {
        $this->redirect('archive');
    }
    
    /**
     * Main processing body of the Controller
     *
     * @param $parameters
     *
     * Article|false $article Article to display
     * @return void
     */
    function process($parameters)
    {
        $this->articlePosts();
        
        //Article itself
        $fetch = new FetchOperations($this->handler);
        $article = $fetch->article($parameters[0]);
    
        if (!$article) {
            http_response_code(404);
            $this->redirect('notice/404-article-not-found');
            exit;
        }
    
        $article->parseContent();
    
        //Related items
        $next = $article->getRelatedPreview('next', $this->handler);
        $previous = $article->getRelatedPreview('previous', $this->handler);
        $related = $article->getRelatedPreviews($this->handler);
        $categories = $article->getCategories($this->handler);
    
        //Translate
        $theWordArticle = (LocaleAM::code() === 'en-us') ? 'Article' : 'Článek';
    
    
        //Comments
        $comments = []; //TODO: $fetch->comments($article->id_article);
        
        
        
        //$fetch->addView($article->id_article_translated);
        
        
        $this->setData(
            ['article', 'next', 'previous', 'related', 'categories', 'commentArray', 'breadcrumbs'],
            [$article, $next, $previous, $related, $categories, $comments, $this->breadcrumbs($categories, 'article')],
            'article'
        );
    
    
    
        
        $this->setHeaders(
            $article->title . ' | ' . $theWordArticle,
            $article->keywords,
            $article->digest,
            'index,nofollow',
            [
                ['og:url', 'https://www.toms.click' . $_SERVER['REQUEST_URI']],
                ['og:type', 'website'],
                ['og:site_name', 'Toms.click'],
                ['og:title', $article->title . ' | ' . $theWordArticle . ' | Toms.click'],
                ['og:image', 'https://www.toms.click/src/View/image/' . str_replace('.svg', '.png', $article->src)],
                ['og:locale', LocaleAM::code()],
                ['og:description', $article->digest]
            ]
        );
        
        
        
        $this->view = '_latte/article';
    }
    
    private function articlePosts()
    {
        if (isset($_POST['comment']) && isset($_POST['name']) && isset($_POST['capcha']) && isset($_POST['content']) && isset($_POST['id_article'])) {
            $db = new Db($this->handler);
            if ($_POST['capcha'] === strftime("%Y")) {
                $db->modify('INSERT INTO comment (id_article, name, content) VALUE (?, ?, ?)', [$_POST['id_article'], $_POST['name'], $_POST['content']]);
            }
            
            echo '<meta id="notification-meta" name="notification-meta" content="Thanks for the comment! Your comment is pending approval." />';
        }
        
        if (isset($_POST['reply']) && isset($_POST['id_parent']) && isset($_POST['name']) && isset($_POST['capcha']) && isset($_POST['content']) && isset($_POST['id_article'])) {
            $db = new Db($this->handler);
            if ($_POST['capcha'] === strftime("%Y")) {
                $db->modify('INSERT INTO comment (id_article, name, content, id_parent) VALUE (?, ?, ?, ?)', [$_POST['id_article'], $_POST['name'], $_POST['content'], $_POST['id_parent']]);
            }
            
            echo '<meta id="notification-meta" name="notification-meta" content="Thanks for the comment! Your comment is pending approval." />';
        }
        
        if (isset($_POST['upvote'])) {
            $db = new Db($this->handler);
            $db->modify('UPDATE comment SET rating = rating + 1 WHERE id_comment = ?', [$_POST['upvote']]);
            
            $this->refresh();
            
        }
        if (isset($_POST['downvote'])) {
            $db = new Db($this->handler);
            $db->modify('UPDATE comment SET rating = rating - 1 WHERE id_comment = ?', [$_POST['downvote']]);
            
            $this->refresh();
        }
    }
}