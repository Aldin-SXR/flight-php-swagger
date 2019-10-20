<?php

use HttpLog\HttpLogger;

/**
 * FlightPHP logger.
 * Logs all incoming requests and outgoing responses into a log file, using FightPHP middleware. 
 * Contents of the log, as well as its destination, can be modified via the HttpLogger::create() method.
 */

/* Disbale FlightPHP's internal error logger. */
Flight::set('flight.handle_errors', false);
HttpLogger::create('file', 'full+h', LOG_FILE, false);

/* Flight middleware | Logging */
Flight::after('start', function(&$params, &$output) {
    if (Flight::request()->url !== '/') {
        $logger = HttpLogger::get();
        $logger->log();
    }
});

/**
 * Custom Flight::output function.
 * JSON outputting function which comes with an embedded logger.
 * Can be used instead of the logging middleware.
 */

/* Custom output function */
Flight::map('output', function($data, $response_code  = 200) {
    header('Content-Type: application/json');
    Flight::json($data, $response_code);
    $logger = HttpLogger::get();
    $logger->log();
    die;
});

/**
 * Custom Flight::validate function.
 * Uses the Validator utility class to validate an incoming model (request body).
 * Validation refers to the presence of all required fields inside the model (as defined in the models/ folder).
 */
Flight::map('validate', function($class, $data) {
    $validity = Validator::validate_model($class, $data);
    if ($validity && array_key_exists('invalid_field', $validity)) {
        Flight::output([
            'error_message' => 'Field `'.$validity['invalid_field'].'` is required.'
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