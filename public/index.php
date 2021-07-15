<?php

$startTime = microtime(true);

use App\Controller\RouterController;
use App\Model\MicroDataOperations;


$liveDb = false;

if ($liveDb && file_exists('../config.live.php'))
    require_once "../config.live.php";
else
    require_once "../config.php";

require_once "../vendor/autoload.php";

MicroDataOperations::setStart($startTime);

//Make it more difficult for JS to steal PHPSESSID (XSS)
ini_set("session.cookie_httponly", 1);

//Transfer session over HTTPS
ini_set("session.cookie_secure", 1);

session_start();

mb_internal_encoding("UTF-8");

//HSTS enable, set to 0 to disable
header("strict-transport-security: max-age=600");

/** @var RouterController $router processes URL and parameters */
$router = new RouterController($db);

$router->process($_SERVER['REQUEST_URI']);

$router->view();


//if ($dbParameters[0] === 'localhost') {
//    echo('<meta id="notification-meta" name="notification-meta" content="' . round(($micro2 - $micro), 5) . ' seconds' . '">');
//}


echo('<script>document.getElementById("processing-time").innerHTML = "'.MicroDataOperations::getDifference().'"</script></body></html>');