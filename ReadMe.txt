
this application was built to solve sorting of random cards based on route start - end

- prerequisites:

    1- every card returned from source with following structure:

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
    3- add a virtual host pointing to application root directory
    4- enable override in crated virtual host


- explanations:
    1- entry file is "index.php" which will kick of App.
    2- display file is "display.phtml" which has simple view for sort result
    3- structure now is more advanced and it's more like a framework, it can be enhanced and add many features.
    4- routing is added to application.
    5- application is including files dynamically, this feature can be enhanced in certain parts of the application.
    6- application link structure is http://<base link>/<controller route>/variable1/value1/variable2/value2 ... etc.
    7- system logs should be added to enhance application reporting/tracking
    8- used algorithm, will try to reduce number of loop as much as possible by adding every card
    to final route whenever final route contains the right neighbor card
    9- used algorithm is built in the time of writing this code from scratch as required, didn't use any resource to build it.

- suggestions:
    1- add weight to routes and enhance this algorithm to provide best route.
    2- adding estimated arrival time.
    3- this field is huge and can add lot of features that might be inspired from google maps.

- to start the application, call virtual host link with "plan_trip" link variable like following example "http://local.test.net/plan_trip".





