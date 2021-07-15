<?php

namespace App\Controller;

use App\Model\ArchiveOperations;
use App\Model\LocaleAM;
use App\Model\Topic;

class ArchiveController extends Controller
{
    /**
     * Main processing body of the Controller
     *
     *  Works the same as process() by default
     *
     * @var Topic|false       $currentTopic
     * @var ArchiveOperations $archive
     *
     * @return void
     */
    public function processParameterless()
    {
        $archive = new ArchiveOperations($this->handler);
        
        //Subcategories and articles
        $sections = $archive->archiveRoot();
        
        $currentTopic = new Topic(null, 'Root', null, $this->handler);
        
        $supercategories = $archive->getRootSupercategories();
        
        $this->setDataAndHeaders($currentTopic, $sections[1], $sections[0], $supercategories);
    }
    
    /**
     * Main processing body of the Controller
     *
     * @param array           $parameters
     *
     * @var ArchiveOperations $archive
     * @var Topic|false       $currentTopic
     *
     * @return void
     */
    public function process($parameters)
    {
        $archive = new ArchiveOperations($this->handler);
        
        //Subcategories and articles
        if (is_numeric($parameters[0])) {
            $currentTopic = $archive->numericLinkAccess($parameters[0]);
        } else {
            $currentTopic = $archive->stringLinkAccess(end($parameters));
        }
        
        if(!$currentTopic) {
            $this->redirect('notice/404-not-found');
            exit;
        }
        
        $currentTopic->connectDb($this->handler);
        
        $articles = $currentTopic->getArticles();
        
        $subcategories = $currentTopic->getSubcategories();
        
        $supercategories = $currentTopic->getSupercategories();
        
        $this->setDataAndHeaders($currentTopic, $articles, $subcategories, $supercategories);
    }
    
    /**
     * @param topic $currentTopic
     * @param array $articles
     * @param array $subcategories
     * @param array $supercategories
     */
    private function setDataAndHeaders($currentTopic, $articles, $subcategories, $supercategories)
    {
        $this->setData([
            'topic', 'articles', 'subcategories', 'supercategories', 'breadcrumbs'
        ], [
            $currentTopic, $articles, $subcategories, $supercategories, $this->breadcrumbs($supercategories)
        ],
            'article'
        );
        
        //Translate and connect
        $theWordArchive = ucfirst($this->data['localizationData']['archive']);
        $title = ($currentTopic->title ?? 'Root') . ' | ' . $theWordArchive;
        
        $this->setHeaders($title, '', $theWordArchive, 'index,follow', [
            ['og:description', $theWordArchive],
            ['og:url', 'https://www.toms.click' . $_SERVER['REQUEST_URI']],
            ['og:type', 'website'],
            ['og:site_name', 'Toms.click'],
            ['og:title', $title . ' | Toms.click'],
            ['og:image', 'https://www.toms.click/src/View/image/anubite-preview.png'],
            ['og:locale', LocaleAM::code()]
        ]);
        
        
        
        $this->view = '_latte/archive';
    }
}