
this application was built to solve sorting of random cards based on route start - end

- prerequisites:

    1- every card is an array with following structure:

        [
                "start"=> <Start point name>,
                "end"=><end point name>,
                "transportType" => <transport type key can be used in future>,
                "transportName" => <transport name, human readable>,
                "transportDetails" => [
                    <details needed for transport>
                ],
        ]

    2- there is no discontinuity among all cards, meaning there is no isolated card with start/end
    that not reachable from any other card


- explanations:
    1- entry file is "index.php" which has an example definition for cards stack.
    2- display file is "display.phtml" which has simple view for sort result
    3- used simple class as main sorter which has only one function, this class can be integrated
    and used in any system and can be improved later.
    4- used algorithm, will try to reduce number of loop as much as possible by adding every card
    to final route whenever final route contains any right neighbor card
    5- used algorithm is now built from scratch as required, didn't use any resource to build it.
    6- wan't able to meet/create all required files due to time limit.

- suggestions:
    1- add weight to routes and enhance this algorithm to provide best route.
    2- adding estimated arrival time.
    3- this field is huge and can add lot of features that might be inspired from google maps.

- to start the application, call index.php from your browser.
- complexity digree: (n - 1)(n - 2)





