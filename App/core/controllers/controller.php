<?php

namespace App\core\controllers;

/**
 * Created by PhpStorm.
 * User: rami
 * Date: 22/12/17
 * Time: 10:28
 */

class coreController {

    var $template;
    function __construct($template = "")
    {
        $this->template = $template;
    }

    /**
     * use to kick off execution
     */
    function execute() {
        $this->dispatchDisplay();
    }

    /**
     * use to kick off display
     */
    function dispatchDisplay(){
        if($this->template) {
            require_once($this->template);
        }
    }
}