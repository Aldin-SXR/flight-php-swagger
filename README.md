# [WIP] Flight/Swagger bundle
[Flight PHP](http://flightphp.com/) micro-framework bundled with [Swagger](http://zircote.com/swagger-php/), [PHPUnit](https://phpunit.de/) and other useful utilities.
Designed to help kick-start the development of APIs built with the aforementioned tools by including the basic project setup, test routes and models, as well as the template for unit tests.

## Getting started

### Prerequisites
This guides assumes that you are currently using (or planning to use) the following technologies in your project:
- PHP 7.1+
- [Composer](https://getcomposer.org/)
- [Xdebug](https://xdebug.org/) (required if you plan on using PHPUnit)

### Installing
1. First, make sure that you have installed and configured a running web server (such as Apache) with PHP 7.1 or higher.
2. Use `composer` to download the project skeleton, install all required dependencies, and run the sample unit tests:

    `composer create-project tribeos/flight-php-swagger path/to/project`

### Project structure
Once the installation is finished, you will find this structure in your project:

```
path/to/project
├── app 
│   ├── models
│   │   └── SampleModel.php
│   ├── routes
│   │   ├── flight_setup.php
│   │   └── sample_route.php
│   └── utils
│       ├── Logger.php
│       └── ModelValidator.php
├── config
│   ├── Config.php
│   └── Config.sample.php
├── docs
├── logs
│   └──  .htaccess
├── tests
│   ├── build
│   └── src
│       └── SampleTest.php
├── vendor
├── .gitignore
├── .htaccess
├── composer.json
├── composer.lock
├── index.php
├── LICENSE
├── phpunit.xml
└── README.md
```
Rundown of main project components:

- `app`: the main application folder
    - `models`: models used for requests/responses
    - `routes`: definition of API routes
    - `utils`:  application utilites, such as validtors and loggers
- `config`: configuration file(s)
- `docs`: Swagger documentation files
- `logs`: logs storage
- `tests`: application tests folder
    - `build`: any compiled files resulting form tests (code coverage, etc.)
    - `src`: test source files
- `vendor`: location of all libraries and third-party code
- `index.php`: API entry point and inclusion of all requried files
- `phpunit.xml`: PHPUnit testing configuration

### Working on the project

#### Project configuration
All main configuration related to the project (and Swagger documentation) is handled inside the `config/Config.php` file. 
Change/add the configuration constants according to your project needs.

Another important file is `index.php`, which serves as the API entry point. All necessary imports are defined within it, and the Flight framework is started. The files imported by default are all `models`, `routes` and `utils`, as well as the project configuration file (`config/Config.php`), Swagger-PHP configuration file (`docs/swagger.php`) and the Composer's `vendor/autoload.php`.
Change/add imported files according to your project needs.

#### Flight
[Flight](http://flightphp.com/) is an extensible and easy-to-use PHP framework which allows for fast creation of RESTful web APIs. It enables you to create detailed and functional API endpoints, coupled with middleware functionalities and the ability to override/create custom methods.

```php
Flight::route('GET /sample/@value', function($value) {
    Flight::json([ "sample_value" => $value ]);
});
```

All routing in the project is done via Flight. The initial Flight setup (`flight_setup.php`), as well as all project routes are handled inside the `routes` folder, and can be changed to suit your needs.

Extensive usage documentation and examples about Flight are available on the [Flight homepage - "Learn" area](http://flightphp.com/learn/).

#### Swagger-PHP
After creating a route in the `routes` folder, you can begin writing and generating [OpenAPI](https://www.openapis.org) documentation for your RESTful API.

Documentation is written inside _DocBlocks_, a.k.a PHP comment blocks, above the corresponding route.  
```php
/** 
 * @OA\Get(
 *      path="/sample/route",
 *      tags={"sample"},
 *      summary="A sample route.",
 *      @OA\Response(
 *           response=200,
 *           description="A sample response."
 *      ),
 *     security={
 *          {"api_key": {}}
 *      }
 * )
*/
```
You can define the path, tags, short summary, parameters, request body, available responses, security authentication and numerous other options for every RESTful endpoint. 

General Swagger configuration, such as the project name, project author(s), API server URL, specification folders, etc. can be found and configured in `config/Config.php`, under the _"Swager configuration constants"_ area. 

The project skeleton comes coupled with the `docs` folder, which holds all necessary files for Swagger documentation (PHP setup files, HTML and CSS). The documentation is accessed by navigating to the root route (`/`) of your project via a browser.

For more information about Swagger in general, and the OpenAPI standard, refer to [Swagger official homepage](https://swagger.io/). 
Extensive usage documentation and examples regarding the PHP implementation are available on the [swagger-php official homepage](http://zircote.com/swagger-php/). 

#### Project utilities

##### Logger
The project comes bundled with a request/response logger, which will (by default) log every incoming request and its corresponding response into `logs/debug.log`, as tab-separated values (TSV). The logger is configured in `utils\Logger.php`, and by default logs the following information:
- request date
- client IP address
- request method
- route
- query parameters
- request body
- response body
- request headers
- response headers

`Logger` requries the location of the log file (which is by default configured via a constant in `config/Config.php`), and Flight request and response objects as parameters.
```php
Flight::register("logger", "Logger", [ LOG_FILE ]); // log file definition

Flight::logger()->log(Flight::request(), Flight::response());
```

The logger is included via `routes/flight_setup.php`, and configured inside the Flight middleware function `Flight::after()`, which runs after every request (so it is able to fetch the appropriate response). You can change the logger functionalities, as well as the routes it will watch, at your disclosure.

##### `Flight::output()`
`Flight::output()` is a custom mapped method that combines the functionalities of `Flight::json()` (JSON response output), and the custom `Logger`. Any API response that is sent out via this method will automatically be logged, according to the preferences set in the logger.  The method is defined and configured in `routes/flight_setup.php`.

It is useful when you want the logging functionality for your request/response pairs without using Flight middleware to intercept.

`Flight::output()` takes two parameters: the actual data to be sent out (_required_), and the response code (_optional_, 200 by default).
```php
Flight::output(["sample_message" => "Sample response."], 301);
```

##### `Flight::validate()`
`Flight::validate()` uses Swagger-PHP analytics to determine whether a passed-in request body is valid (containing all required attributes) according to the expected model specification. 

All models are declared as classes, and their attributes are set to public. The models are defined in `app/models`, and follow this structure:
```php
/**
 * @OA\Schema(
 * )
 */
class SampleModel {
    /**
     * @OA\Property(
     * description="Sample attribute of the request body.",
     * required=true
     * )
     * @var string
     */
    public $sample_attribute;
}
```
For more information about model schemas, refer to [Swagger-PHP documentation](http://zircote.com/swagger-php/Getting-started.html#reusing-annotations-ref).

The model validator class is declared and defined in `utils/ModelValidator.php`, and included as a custom mapped Flight method in `routes/flight_setup.php`. It takes two parameters: the class against which the request body is to be validated, and the request body itself. 
```php
Flight::validate(SampleModel::class, Flight::request()->data->getData());
```

The method should be called inside an API route, before any additional methods are called, as it will output a `400 Bad Request` response code if the model fails to validate. 

_Note_: `Flight::validate()` depends on `Flight::output()`, so if you plan on removing the custom output method from the project, you should rewrite the validator mapped method as required.

### Testing the project
The project comes included with [PHPUnit](https://phpunit.de/index.html), a testing framework for PHP which, in addition to testing itself, also allows for code coverage generation.

#### Test setup
All setup related to testing with PHPUnit is located in `phpunit.xml`. There are several options available for setting up:

1. The location of test files
Inside the `testsuites` tag, the location which will be scanned for tests can be defined. By default, this is `tests/src`. When a test directory is defined (via `directory` tag), the test files will be run in alphabetical order during test execution. If we need, we can also define the test files in a custom order via `file` tag.

```xml
    <testsuites>
        <testsuite name="sample-test-suite">
            <directory suffix="Test.php">tests/src/</directory>
            <!-- By default, test files will be run in alphabetical file order. If you want to set a specific order of execution, define individual test files-->
            <!-- <file>tests/src/SampleTest.php</file> -->
        </testsuite>
    </testsuites>
``` 

2. Types of test coverage reports
Different types of testing reports can be generated after the tests are run. The log types are defined in the `logging` tag. All built files are, by default, located inside `tests/build`.

```xml
    <logging>
        <!-- Types of testing logs -->
        <log type="testdox-html" target="tests/build/testdox.html"/>
        <log type="tap" target="tests/build/report.tap"/>
        <log type="junit" target="tests/build/report.junit.xml"/>
        <log type="coverage-html" target="tests/build/coverage"/>
        <log type="coverage-text" target="tests/build/coverage.txt"/>
        <log type="coverage-clover" target="tests/build/logs/clover.xml"/>
    </logging>
```

3. Files to be included/excluded from code coverage
You can also choose which files will be included in (or excluded from) the code coverage report. That is done through the `filter` tag, inside the `whitelist` tag. By default, the project's PHPUnit setup covers files within the `app` directory, excluding `models`, `routes` and `utils/Logger.php`. You can also define your custom inclusion/exclusion folders and files.

```xml
    <filter>
        <whitelist>
            <!-- The name of the folder to use for code coverage -->
            <directory suffix=".php">app/</directory>
            <exclude>
                <!-- Files/folders excluded from code coverage (PHP files without testable methods). Edit according to your project needs. -->
                <directory suffix=".php">app/models</directory>
                <directory suffix=".php">app/routes</directory>
                <file>app/utils/Logger.php</file>
            </exclude>
        </whitelist>
    </filter>
```

#### Writing the tests
All tests should be, by default, written inside the `tests/src` directory. Test file names should end with `Test.php`, so that they are discoverable by PHPUnit (as defined in `phpunit.xml`), e.g. `SampleTest.php`.

A test class is defined as extending the `TestCase` class, and it can include various test methods. When naming the tests, you can use the following convention: `test` + description of the test in camel case (e.g. `testThisIsASampleTest`). This will allow the test case name to be converted to a descriptive sentence during test execution, giving additional overview to the developer about what the test should do.

```php
/* tests/src/SampleTest.php */

<?php
use PHPUnit\Framework\TestCase;

class SampleTest extends TestCase {

    public function testThisIsASampleTest() {
        $this->assertTrue(true);
    }
}
```

#### Test execution
To execute all tests, run `vendor/bin/phpunit --testdox` inside the project's root directory. 

```xml
root@ubuntu:/path/to/project$ vendor/bin/phpunit --testdox
PHPUnit 7.5.4 by Sebastian Bergmann and contributors.

Sample
 ✔ This is a sample test
```

To run only a single test file, supply its path: `vendor/bin/phpunit --testdox tests/src/SampleTest.php` 

The flag `--testdox` is optional, but recommended, as it will generate descriptive sentences about the tests based on their names (as discussed in the section above), making it easier to understand what had been going on inside the tests.

After executing the tests, the code coverage report is generated inside `tests/build/coverage` directory, and can be viewed by opening this path via a browser.

## Authors
- __Aldin Kovačević__, _initial work on the skeleton and documentation_ - [Aldin-SXR](https://github.com/Aldin-SXR)

## License
The skeleton is licensed under the [MIT](http://www.opensource.org/licenses/mit-license.php) license. See the [LICENSE](https://github.com/Aldin-SXR/flight-php-swagger/blob/master/LICENSE) file for details.

---

_Work in progress._ 