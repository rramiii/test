<?php

namespace App\trip_reoute\controllers\organise_trip;

/**
 * Created by PhpStorm.
 * User: rami
 * Date: 22/12/17
 * Time: 10:45
 */

use \App\core\controllers\coreController as coreController;
use \App\trip_reoute\model\CardSorter as CardSorter;

class controller extends coreController {

    var $cardSorter;
    var $sortedRoute;
    function __construct($template = "")
    {
        $this->cardSorter = new CardSorter();
        parent::__construct($template);
    }

    function execute()
    {
        $this->sortedRoute = $this->cardSorter->getSortedRoute();
        parent::execute();
    }
}