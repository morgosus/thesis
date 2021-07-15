<?php
/** @var App\Controller\RouterController $this */

//TODO: Move this into the header model

$restOfTitle = ($_SESSION['localization']->id === 1) ? 'Personal website of a random student' : 'Osobní web náhodného studenta';
echo '<title>' . (($this->controller->header->getTitle() !== '') ? ($this->controller->header->getTitle() . ' | Toms.click | ' . $restOfTitle) : 'Toms.click - ' . $restOfTitle) . '</title>';
?>
    <meta name="robots" content="<?= $this->controller->header->getRobots() ?>" />
    
    <meta name="description" content="<?= $this->controller->header->getDescription() ?>" />
    
    <meta name="keywords" content="<?= $this->controller->header->getKeywords() ?>" />
    
    <meta name="author" content="Martin Toms" />
    
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />

<?php $this->controller->header->writeMicrodata(); ?>