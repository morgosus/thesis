<?php

use App\Model\Db;

require_once "../config.php";
require_once "../vendor/autoload.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");

switch ($_GET['do'] ?? false) {
    case 'search':
        if (($_GET['language'] ?? false) && ($_GET['content'] ?? false))
            search($db, $_GET['language'], $_GET['content']);
        else header("HTTP/1.1 400 Bad Request");
        break;
    default:
        header("HTTP/1.1 400 Bad Request");
}

/**
 * @param PDO $handler
 * @param     $language
 * @param     $content
 */
function search($handler, $language, $content)
{
    $db = new Db($handler);
    
    $results = $db->select(
        'SELECT
                  title, link, digest, name, src, MATCH (title, content, digest, link) AGAINST (?) AS relevance
                  FROM publicArticles
                  WHERE
                  (MATCH(title, content, digest, link)
                  AGAINST (?)) AND id_language = ?
                  ORDER BY relevance DESC', //TODO: Might want to remove content
        [
            '\'' . $content . '\' \'' . $content . '\'',
            '\'>"' . $content . '"\' <\'' . $content . '*\' IN BOOLEAN MODE',
            $language
        ], true
    );
    

    
    echo json_encode($results);
    exit;
}