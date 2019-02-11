<?php
require_once __DIR__."/utils/Logger.php";

Flight::register("logger", "Logger", [ "logs", "debug.log" ]);

/* Flight middleware | Logging */
Flight::after("start", function(&$params, &$output) {
    if (Flight::request()->url !== "/") {
        Flight::logger()->log(Flight::request(), Flight::response());
    }
});