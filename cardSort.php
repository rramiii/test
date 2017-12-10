<?php

class CardSorter {
    /**
     * method used to sort random set of cards
     *
     * @param array $cards
     * @return array
     */
    function getSortedRoute($cards) {

        $route = [];            // final route holder
        if(count($cards) >0) {

            $route = [array_shift($cards)];
            while (count($cards) > 0) {

                $card = $cards[0];
                for($count = 0; $count < count($route); $count++) {

                    $position = -1;     // inital state for card position
                    if($card["start"] == $route[$count]["end"]){
                        $position = $count+1;
                    }elseif($card["end"] == $route[$count]["start"]) {
                        $position = $count;
                    }

                    if($position >= 0) {   // if card can be added to route stack now
                        array_splice($route, $position, 0, [$card]);

                        array_shift($cards);  // remove current card from cards stack
                        break;
                    }
                    if($count == (count($route) - 1)) {  // if reached end of routes and
                        // didn't find position for current card yet

                        array_push($cards, array_shift($cards));  // move current card to end of cards queue
                    }
                }
            }
        }
        return $route;
    }
}