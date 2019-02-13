<?php
/**
 * Entry point for the FlightPHP project, bundled with Swagger OpenAPI documentation generator.
 */

require_once __DIR__."/vendor/autoload.php";
require_once __DIR__."/docs/swagger.php";

/**
 * Required files, modules & libraries.
 */
require_once __DIR__."/config/Config.php";
foreach (glob(__DIR__."/app/utils/*.php") as $utils) {
    require_once $utils;
}
foreach (glob(__DIR__."/app/routes/*.php") as $routes) {
    require_once $routes;
}
foreach (glob(__DIR__."/app/models/*.php") as $models) {
    require_once $models;
}

/**
 * Start the Flight framework.
 */
Flight::start();