<?php

namespace App\Model;

/**
 * Localization Container
 *
 * This class is loaded into the session as soon as the application decides what the localization is.
 * It contains all sorts of localization related items.
 *
 * It's accessed through LocaleAM static class for the moment. Why? Well, a) it was built on the go, I also want the
 * static methods to have the same name as the nonstatic ones.
 *
 * @package App\Model
 */
class LocalizationContainer
{
    public $code;
    public $id;
    public $format;
    
    /**
     * Localization constructor.
     *
     * @param $Code
     */
    public function __construct($Code)
    {
        $this->code = $Code;
        
        switch ($this->code) {
            case 'en-us':
                $this->format = '%e%O %B %G';
                $this->id = 1;
                break;
            case 'cs-cz':
                $this->format = '%e. %B %G';
                $this->id = 2;
                break;
            default:
                $this->code = 'en-us';
                $this->id = 1;
                break;
        }
    }
    
    public function setLoc()
    {
        if ($this->id === 1) {
            return setlocale(LC_TIME, 'en_US.UTF-8');
        }
        return setlocale(LC_TIME, 'cs_CZ.UTF-8');
        
    }
    
    public function timeDifference($timeIso8601)
    {
        $timeOld = new \DateTime($timeIso8601);
        
        $difference = $timeOld->diff(new \DateTime(), true);
        
        $indices = ['y', 'm', 'd', 'h', 'i'];
        
        
        $difference = $this->loopDifference($difference, $indices);
        
        if ($this->id === 1) {
            return $this->englishDifference($difference);
        }
        return $this->czechDifference($difference);
    }
    
    private function czechDifference($difference)
    {
        if (($difference[0] ?? false) === 1)
            $timeWords = [' rokem', ' měsícem', ' dnem', ' hodinou', ' minutou'];
        else
            $timeWords = [' roky', ' měsíci', ' dny', ' hodinami', ' minutami'];
        
        switch ($difference[1] ?? false) {
            case 'y':
                $difference = 'Před ' . $difference[0] . $timeWords[0];
                break;
            case 'm':
                $difference = 'Před ' . $difference[0] . $timeWords[1];
                break;
            case 'd':
                $difference = 'Před ' . $difference[0] . $timeWords[2];
                break;
            case 'h':
                $difference = 'Před ' . $difference[0] . $timeWords[2];
                break;
            case 'i':
                $difference = 'Před ' . $difference[0] . $timeWords[3];
                break;
            default:
                $difference = 'Před méně než minutou';
        }
        
        return $difference;
    }
    
    private function englishDifference($difference)
    {
        switch ($difference[1] ?? false) {
            case 'y':
                $difference = $difference[0] . ' years ago';
                break;
            case 'm':
                $difference = $difference[0] . ' months ago';
                break;
            case 'd':
                $difference = $difference[0] . ' days ago';
                break;
            case 'h':
                $difference = $difference[0] . ' hours ago';
                break;
            case 'i':
                $difference = $difference[0] . ' minutes ago';
                break;
            default:
                $difference = 'Less than a minute ago';
        }
        
        return $difference;
    }
    
    private function loopDifference($difference, $indices)
    {
        foreach ($indices as $index) {
            if ($difference->$index) {
                return [$difference->$index, $index];
            }
        }
        
        return false;
    }
    
    public function __toString()
    {
        return $this->code;
    }
}