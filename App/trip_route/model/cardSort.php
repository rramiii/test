<?php

namespace App\trip_reoute\model;

use App\core\model\coreModel as coreModel;
class CardSorter extends coreModel{

    private $cardStack = [];
    private $sortedRoute = [];
    private $isCardsSorted = false;

    function __construct()
    {
        $this->init();
        parent::__construct();
    }

    function init(){
        $this->setCardStack($this->fetchCards());
    }

    function fetchCards() {
        // perform the needful to get cards array and return it.
        return [
            [
                "start"=> "Gerona Airport",
                "end"=>"Stockholm",
                "transportType" => "flight",
                "transportName" => "flight SK455",
                "transportDetails" => [
                    "Gate 45B",
                    "seat 3A",
                    "Baggage drop at ticket counter 344"
                ],
            ],
            [
                "start"=> "Madrid",
                "end"=>"Barcelona",
                "transportType" => "train",
                "transportName" => "train 78A",
                "transportDetails" => [
                    "Sit in seat 45B",
                ],
            ],
            [
                "start"=> "Stockholm",
                "end"=>"New York JFK",
                "transportType" => "flight",
                "transportName" => "flight SK22",
                "transportDetails" => [
                    "Gate 22",
                    "seat 7B",
                    "Baggage will we automatically transferred from your last leg"
                ],
            ],
            [
                "start"=> "Barcelona",
                "end"=>"Gerona Airport",
                "transportType" => "bus",
                "transportName" => "airport bus",
                "transportDetails" => [
                    "No seat assignment",
                ],
            ],
        ];
    }

    private function pushToCardStack(card $card) {
        array_push($this->cardStack, $card);
    }

    private function resetCardStack(){
        $this->cardStack = [];
    }

    function setCardStack($stack) {

        $this->resetCardStack();
        $this->isCardsSorted = false;
        foreach ($stack as $card) {
            if(is_a($card, 'card', true)) {
                $this->pushToCardStack($card);
            } else {
                $this->pushToCardStack(new card($card));
            }
        }
    }

    function getCardStack() {
        return $this->cardStack;
    }

    /**
     * method used to sort random set of cards
     *
     * @return bool
     */
    function buildSortedRoute() {
        $cards = $this->getCardStack();
        $route = [];            // final route holder

        if(count($cards) >0) {

            $route = [array_shift($cards)];
            while (count($cards) > 0) {

                $card = $cards[0];
                for($count = 0; $count < count($route); $count++) {
                    if(($position = $card->isNeighbor($route[$count])) != card::not_neighbor) {   // if card can be added to route stack now

                        array_splice($route, $position + $count, 0, [$card]); // insert card in right position
                        array_shift($cards);  // remove current card from cards stack
                        break;
                    }
                    if($count == (count($route) - 1)) {  // if reached end of routes and didn't find position for current card yet

                        array_push($cards, array_shift($cards));  // move current card to end of cards queue
                    }
                }
            }
        }

        $this->sortedRoute = $route;
        $this->isCardsSorted = true;
        return true;
    }

    function getSortedRoute(){
        if(!$this->isCardsSorted) {
            $this->buildSortedRoute();
        }
        return $this->sortedRoute;
    }
}