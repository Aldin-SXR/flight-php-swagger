<?php
/**
 * Sample of the configuration file. Replace with your own configuration constants.
 */

/**
 * Project constants and definitions.
 */

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

define("API_BASE_PATH", explode("/", dirname(dirname(__FILE__)))[count(explode("/", dirname(dirname(__FILE__)))) - 1]); // path to your server/API
define("PROJECT_TITLE", "Flight/Swagger bundle"); // project title
define("PROJECT_DESCRIPTION", "FlightPHP micro-framework bundled with Swagger and other useful utilities."); // project description
define("PROJECT_VERSION", "0.1"); // project version

define("AUTHOR_NAME", "Aldin Kovačević");
define("AUTHOR_EMAIL", "aldin@tribeos.io");
define("AUTHOR_URL", "https://www.linkedin.com/in/aldin-kovacevic/");