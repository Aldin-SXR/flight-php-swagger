<?php
/**
 * Sample of the configuration file. Replace with your own configuration constants.
 */

/**
 * Project constants and definitions.
 */

define("LOG_FILE", __DIR__."/../logs/debug.log");

/**
 * Swagger configuration constants.
 * Change these constants to fit your project needs.
 */

define("DOCS_FOLDER", "docs"); // relative path from the project root
/* Folders/files containing OpenAPI annotations. */
define("DOCS_ANNOTATION_LOCATIONS", [
    __DIR__."/../app/models/",
    __DIR__."/../app/routes",
    __DIR__."/../docs/doc_setup.php"
]);

/* Project definitions */
if (explode(" ", php_uname("s"))[0] === "Windows") {
    $slash = "\\";
} else {
    $slash = "/";
}
define("API_BASE_PATH", "http://localhost/".explode($slash, dirname(dirname(__FILE__)))[count(explode($slash, dirname(dirname(__FILE__)))) - 1]); // path to your server/API
define("AUTH_HEADER_NAME", "Authorization"); // name of the authorization header to be used
define("SERVER_DESCRIPTION", "Flight/Swagger API skeleton."); // description of the host server
define("PROJECT_TITLE", "Flight/Swagger bundle"); // project title
define("PROJECT_DESCRIPTION", "FlightPHP micro-framework bundled with Swagger and other useful utilities."); // project description
define("PROJECT_VERSION", "0.1"); // project version
define("PROJECT_DOCS_TITLE", "FlightPHP/Swagger bundle"); // title of the HTML page for the generated documentation 

/* Author/team definitions */
define("AUTHOR_NAME", "Aldin Kovačević");
define("AUTHOR_EMAIL", "aldin@tribeos.io");
define("AUTHOR_URL", "https://www.linkedin.com/in/aldin-kovacevic/");