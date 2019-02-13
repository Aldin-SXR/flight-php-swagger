<?php

/**
 * FlightPHP logger.
 * Logs all incoming requests and outgoing responses into a log file, using FightPHP middleware. 
 * Contents of the log, as well as its destination, can be modified inside the app/utils/Logger.php file.
 */

Flight::register("logger", "Logger", [ __DIR__."/../../logs/debug.log" ]);

/* Flight middleware | Logging */
Flight::after("start", function(&$params, &$output) {
    if (Flight::request()->url !== "/") {
        Flight::logger()->log(Flight::request(), Flight::response());
    }
});

/**
 * Custom Flight::output function.
 * JSON outputting function which comes with an embedded logger.
 * Can be used instead of the logging middleware.
 */

/* Custom output function */
Flight::map("output", function($data, $response_code  = 200) {
    header('Content-Type: application/json');
    Flight::json($data, $response_code);
    Flight::logger()->log(Flight::request(), Flight::response());
    die;
});

/**
 * Render Swagger OpenAPI documentation at the project root /
 * Can be changed to fit a custom route.
 */
Flight::route('GET /', function () {
    Flight::set('flight.views.path', './docs');
    Flight::render('index', [ ]);
});