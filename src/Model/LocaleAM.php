<?php

namespace App\Model;

/**
 * Locale Access Method (LocaleAM)
 *
 * Do you ever get tired of writing $_SESSION['localization']->code over and over again?
 * Well! This is what it will eventually lead to! You'll create a static method, or some other way of reducing the
 * occurrences of the dreaded thing.
 * Some might say that this is not a good thing. Some would be wrong ;)
 *
 * This is a static method set that allows you to type LocaleAM instead of $_SESSION['localization'].
 *
 *
 * @package App\Model
 */
class LocaleAM
{
    /**
     * Language code currently stored within the session.
     *
     *
     * @return bool|string when set, it's either en-us or cs-cz
     */
    public static function code()
    {
        return isset($_SESSION['localization']->code)?$_SESSION['localization']->code:false;
    }
    
    /**
     * For initializing the localization within the session.
     *
     * @return mixed
     */
    public static function setLocale()
    {
        return $_SESSION['localization']->setLoc();
    }
    
    /**
     * Format for date functions. Czech localization uses 1. Month etc., while the English one uses 1st Month.
     *
     * @return mixed
     */
    public static function format()
    {
        return $_SESSION['localization']->format;
    }
    
    
    /**
     * Generates a 'x months/seconds/days ago' string.
     *
     * @param $creationIso8601
     * @return string
     */
    public static function timeDifference($creationIso8601)
    {
        return $_SESSION['localization']->timeDifference($creationIso8601);
    }
    
    
    /**
     * Why an id? Because this used to be in a database.
     *
     * @return bool
     */
    public static function id() {
        return isset($_SESSION['localization']->id)?$_SESSION['localization']->id:false;
    }
    
    
    /**
     * In case we want to make sure that the session is set and hasn't changed.
     *
     * For chaning the session based on url or initializing it.
     *
     * @param $newLangcode
     * @return bool
     */
    public static function notSetOrChanged($newLangcode) {
        return (!isset($_SESSION['localization']) || $newLangcode !== $_SESSION['localization']->code);
    }
}