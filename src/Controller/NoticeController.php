<?php

namespace App\Controller;


class NoticeController extends Controller
{
    
    function process($parameters)
    {
        $this->headerAndFooter = false;
        
        if (isset($parameters[0]) && file_exists(__DIR__ . '/../View/notice/' . $parameters[0] . '.php')) {
            switch ($parameters[0]) {
                case '404-not-found':
                    http_response_code(404);
                    break;
                case '404-article-not-found':
                    http_response_code(404);
                    break;
                case '403-forbidden':
                    http_response_code(403);
                    break;
                case '401-unauthorized':
                case 'feature-requires-cookies':
                    http_response_code(401);
                    break;
                case 'failure':
                    http_response_code(500);
                    break;
                default:
                    http_response_code(200);
                    break;
            }
            
            
            
            $this->setHeaders(
                'Notice',
                null,
                false,
                'noindex,nofollow'
            );
            
            
            
            $this->view = 'notice/' . $parameters[0];
        } else {
            http_response_code(404);
            $this->view = 'notice/404-not-found';
        }
    }
}
