<?php
require_once __DIR__."/vendor/autoload.php";

require_once __DIR__."/utils/Logger.php";

Flight::register("logger", "Logger", [ "logs", "debug.log" ]);


Flight::route("POST /test", function() {
    Flight::json([ "meow" => "meow" ]);
    Flight::logger()->log(Flight::request(), Flight::response());
});

Flight::start();