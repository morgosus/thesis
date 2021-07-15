<?php
/**
 * Each segment should be separated by three (3) line breaks, each closely related item should be literally close, no
 * line breaks (0). Each configuration item should have a clear datatype and usage.
 *
 * Why did I decide to use global constants for configuration? Well...
 *
 * 0) it's really easy to read and orient in
 * a) constants can't be edited, the configuration over here should be stable
 * b) they're global, so the usage isn't painful
 * c) the naming conventions are pretty consistent, so now everyone knows the conventions for the naming here
 * d) they're not arrays, so they get autocompleted
 * e) there's not htat much of a processing time as compared to parsing an xml or something
 * f) it's not verbose, it has just the right amount of text
 *
 */

/** (number) Version of all files, stylesheets, etc.*/
define('FILE_VERSION', 1.512);



/** (array) For translation of pages
 *  e.g. /cs-cz/domovska-stranka will lead to the same thing as /en-us/homepage */
define('ROUTING_TABLE', [
    'Domovska-strankaController' => 'HomepageController',
    'ClanekController' => 'ArticleController',
    'O-nasController' => 'AboutController',
    'ArchivController' => 'ArchiveController',
    'RecepceController' => 'HomepageController',
    'UzivatelController' => 'UserController'
]);



/** Caching of the (array)CACHED_ITEMS for (int)CACHE_TIME seconds is (bool)CACHE_ENABLED*/
define('CACHE_ENABLED', false);
define('CACHE_TIME', 86400);
define('CACHED_ITEMS', [
    'HomepageController',
    'ArticleController',
    'ArchiveController',
    'AboutController',
    'AboutController'
]);



/** Database credentials */
$dbParameters = [
    'localhost', //host
    'revision-actual', //db name
    'utf8', //encoding
    'root', //username
    '' //password
];

try {
    $db = new PDO('mysql:host=' . $dbParameters[0] . ';dbname=' . $dbParameters[1] .
        ';charset=' . $dbParameters[2], $dbParameters[3], $dbParameters[4]);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
    die('<br>Error accessing the database.');
}