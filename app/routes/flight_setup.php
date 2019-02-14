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
 * Custom Flight::validate function.
 * Uses the ModelValidator utility class to validate an incoming model (request body).
 * Validation refers to the presence of all required fields inside the model (as defined in the models/ folder).
 */
Flight::map("validate", function($class, $data) {
    $validity = ModelValidator::validate_model($class, $data);
    if (array_key_exists("invalid_field", $validity)) {
        Flight::output([
            "error_message" => "Field `".$validity["invalid_field"]."` is required."
        ], 400);
        die;
    }
});

/**
 * Render Swagger OpenAPI documentation at the project root /
 * Can be changed to fit a custom route.
 */
Flight::route('GET /', function () {
    Flight::set('flight.views.path', './docs');
    Flight::render('index', [ ]);
});