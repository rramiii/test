<?php
/**
 * Created by PhpStorm.
 * User: rami
 * Date: 22/12/17
 * Time: 12:56
 */
namespace App\trip_reoute\model;

use App\core\model\coreModel as coreModel;
class card extends coreModel {

    const before = 0;
    const after = 1;
    const not_neighbor = -1;

    private $start = "";
    private $end = "";
    private $type = "";
    private $transportName = "";
    private $details = [];

    function __construct($details)
    {
        $this->setCardDetails($details);
    }
    function setCardDetails($details) {
        $this->start = $details["start"];
        $this->end = $details["end"];
        $this->type = $details["transportType"];
        $this->transportName = $details["transportName"];
        $this->details = $details["transportDetails"];
    }

    function getStart() {
        return $this->start;
    }
    function getEnd(){
        return $this->end;
    }
    function getType(){
        return $this->type;
    }
    function getTransportName() {
        return $this->transportName;
    }
    function getDetails() {
        return $this->details;
    }

    function isNeighbor(card $neighbor) {
        $result = self::not_neighbor;

        if($this->getStart() == $neighbor->getEnd()){
            $result = self::after;
        }elseif($this->getEnd() == $neighbor->getStart()) {
            $result = self::before;
        }
        return $result;
    }
}