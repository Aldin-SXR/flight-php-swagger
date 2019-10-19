<?php
header("Access-Control-Allow-Origin: *");

require_once (__DIR__."/../config/config.php");

error_reporting(1);
ini_set('display_errors', 1);

/**
 * Swagger JSON specification generator.
 * Add the folders containing the specification annotations to the \OpenApi\scan array.
 * By default, routes/ and models/ folders are included, as well as the doc_setup.php setup file.
 */
if (array_key_exists('send', $_GET)) {
    $arr = explode("/", $_GET['send']);
    if ($arr[0] == 'swagger.json') {
        require_once SERVER_ROOT . "/vendor/autoload.php";
        $openapi = \OpenApi\scan(DOCS_ANNOTATION_LOCATIONS);
        $openapi->servers[0]->url = str_replace('docs/swagger.json', '', API_BASE_PATH);

        header('Content-Type: application/json');
        echo $openapi->toJson();
    }        
}