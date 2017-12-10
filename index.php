<?php
require_once("cardSort.php");
/**
 * set of cards to start with as an example
 */
$cards = [
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

$routeSorter = new CardSorter();
$sortedRoutes = $routeSorter->getSortedRoute($cards);

include_once("display.phtml");