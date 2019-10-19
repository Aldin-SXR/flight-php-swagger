# Flight/Swagger bundle


[Flight](http://flightphp.com/) micro-framework bundled with [Swagger](http://zircote.com/swagger-php/), [PHPUnit](https://phpunit.de/) and other useful utilities.
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

#### Enable URL rewriting

Since Flight depends on Apache 2's `mod_rewrite` module in order to function, you should first enable it via `a2enmod` and then restart the server:

`sudo a2enmod rewrite`

`sudo systemctl restart apache2`

Afterwards, you should also edit Apache's default configuration file, as it initially prohibits using an `.htaccess` file to apply rewrite rules. The configuration file is usually located at `/etc/apache2/apache2.conf`. In it, locate the block referring to the directory `/var/www` and make sure that `AllowOverride` is set to `All` and that you `Require all granted`.

```apacheconf
<Directory /var/www/>
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
```

After saving the changes, restart the Apache server.

In case you have, or want to have, multiple site configurations, you can also enable rewrite rules on a per-site basis, by editing the desired configuration file in `/etc/apache2/sites-available`. You can refer to [the following tutorial](digitalocean.com/community/tutorials/how-to-rewrite-urls-with-mod_rewrite-for-apache-on-ubuntu-16-04) for more information.

**Note**: The aforementioned instructions assume you are using an Ubuntu distribution. In case you are using a different operating system, please refer to the appropriate tutorial on enabling the rewrite module.
- [Windows (WAMP/XAMPP)](https://tomelliott.com/php/mod_rewrite-windows-apache-url-rewriting)
- [CentOS](https://devops.ionos.com/tutorials/install-and-configure-mod_rewrite-for-apache-on-centos-7/)

### Project structure
Once the installation is finished, you will find this structure in your project:

```
path/to/project
├── app 
│   ├── models
│   │   └── SampleModel.php
│   ├── routes
│   │   ├── FlightSetup.php
│   │   └── SampleRoute.php
│   └── utils
│       └── ModelValidator.php
├── config
│   ├── config.php
│   └── config.sample.php
├── docs
├── logs
│   └──  .htaccess
├── tests
│   ├── build
│   └── unit
│       └── SampleTest.php
├── vendor
├── .gitignore
├── .htaccess
├── autoload.php
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
- `autoload.php`: A bootstrapping file that loads Composer dependencies, and includes all other project files
- `index.php`: API entry point
- `phpunit.xml`: PHPUnit testing configuration

### Working on the project

#### Project configuration
All main configuration related to the project (and Swagger documentation) is handled inside the `config/config.php` file. 
Change/add the configuration constants according to your project needs.

Another important file is `index.php`, which serves as the API entry point. It requires the file `autoload.php`, which contains the code to load Composer dependencies, as well as all other necessary project files. Moreover, it starts the Flight framework. The files imported by default are all `models`, `routes` and `utils`, as well as the project configuration file (`config/config.php`), Swagger-PHP configuration file (`docs/swagger.php`) and the Composer's `vendor/autoload.php`.
Change/add files to be imported according to your project needs.

#### Flight
[Flight](http://flightphp.com/) is an extensible and easy-to-use PHP framework which allows for fast creation of RESTful web APIs. It enables you to create detailed and functional API endpoints, coupled with middleware functionalities and the ability to override/create custom methods.

```php
Flight::route('GET /sample/@value', function($value) {
    Flight::json([ "sample_value" => $value ]);
});
```

All routing in the project is done via Flight. The initial Flight setup (`FlightSetup.php`), as well as all project routes are handled inside the `routes` folder, and can be changed to suit your needs.

Extensive usage documentation and examples about Flight are available on the [Flight homepage - "Learn" area](http://flightphp.com/learn/). For more details about the Flight framework itself, you can visit [its GitHub repository](https://github.com/mikecao/flight).

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
You can define the path, tags, short summary, parameters, default parameter values, request body, available responses, security authentication and numerous other options for every RESTful endpoint. 

General Swagger configuration, such as the project name, project author(s), API server URL, specification folders, etc. can be found and configured in `config/config.php`, under the _"Swager configuration constants"_ area. 

The project skeleton comes coupled with the `docs` folder, which holds all necessary files for Swagger documentation (PHP setup files, HTML and CSS). The documentation is accessed by navigating to the root route (`/`) of your project via a browser.

For more information about Swagger in general, and the OpenAPI standard, refer to [Swagger official homepage](https://swagger.io/). 
Extensive usage documentation and examples regarding the PHP implementation are available on the [swagger-php official homepage](http://zircote.com/swagger-php/). 

#### Project utilities

##### Logger
The project comes bundled with [http-logger](https://github.com/Aldin-SXR/http-logger), which is a HTTP request, response and error logger, that will (by default) log every incoming request and its corresponding response into `logs/debug.log`, as tab-separated values (TSV). Detailed logger information and configuration details can be found at [its GitHub page](https://github.com/Aldin-SXR/http-logger).

The logger requires the location of the log file (which is by default configured via a constant in `config/config.php`). Moreover, in order to fully utilize the logger's capabilities, Flight's internal error handler should be disabled (if enabled, it will catch certain types of errors before http-logger).

```php
/* Disbale FlightPHP's internal error logger. */
Flight::set('flight.handle_errors', false);
HttpLogger::create('file', 'full+h', LOG_FILE, false);

/* Get and use the logger */
$logger = HttpLogger::get();
$logger->log();
```

The logger is included via `routes/FlightSetup.php`, and configured inside the Flight middleware function `Flight::after()`, which runs after every request (so it is able to fetch the appropriate response). You can change the logger functionalities, as well as the routes it will watch, at your disclosure.

##### `Flight::output()`
`Flight::output()` is a custom mapped method that combines the functionalities of `Flight::json()` (JSON response output), and the custom HTTP Logger. Any API response that is sent out via this method will automatically be logged, according to the preferences set in the logger.  The method is defined and configured in `routes/FlightSetup.php`.

It is useful when you want the logging functionality for your request/response pairs without using Flight middleware to intercept.

`Flight::output()` takes two parameters: the actual data to be sent out (_required_), and the response code (_optional_, 200 by default).
```php
Flight::output(['sample_message' => 'Sample response.'], 301);
```

##### `Flight::validate()`
`Flight::validate()` uses Swagger-PHP analytics to determine whether a passed-in request body is valid (containing all required attributes) according to the expected OpenAPI model specification. 

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
     * example="Sample string."
     * required=true
     * )
     * @var string
     */
    public $sample_attribute;
}
```
In this concrete example, `description` is used to give a brief overview of the model's property, `required` determines whether the property is mandatory or not, and `example` assigns it a default value. For more information about model schemas, refer to [Swagger-PHP documentation](http://zircote.com/swagger-php/Getting-started.html#reusing-annotations-ref).

The model validator class is declared and defined in `utils/ModelValidator.php`, and included as a custom mapped Flight method in `routes/FlightSetup.php`. It takes two parameters: the class against which the request body is to be validated, and the request body itself. 
```php
Flight::validate(SampleModel::class, Flight::request()->data->getData());
```

The method should be called inside an API route, before any additional methods are called. If the model is valid, the request will continue with execution. In case the model fails to validate, it will output a `400 Bad Request` response code, terminating the request.

**Note**: `Flight::validate()` depends on `Flight::output()`, so if you plan on removing the custom output method from the project, you should rewrite the validator mapped method as required.

### Testing the project
The project comes included with [PHPUnit](https://phpunit.de/index.html), a testing framework for PHP which, in addition to testing itself, also allows for code coverage generation.

#### Test setup
All setup related to testing with PHPUnit is located in `phpunit.xml`. There are several options available for setting up:

1. The location of test files
Inside the `testsuites` tag, the location which will be scanned for tests can be defined. By default, this is `tests/unit`. When a test directory is defined (via `directory` tag), the test files will be run in alphabetical order during test execution. If needed, we can also define the test files in a custom order via `file` tag.

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
Different types of testing reports can be generated after the tests are run. The log types are defined in the `logging` tag. All compiled test files are, by default, located inside `tests/build`.

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
You can also choose which files will be included in (or excluded from) the code coverage report. That is done through the `filter` tag, inside the `whitelist` tag. By default, the project's PHPUnit setup covers files within the `app` directory, excluding `models` and `routes` (as these folders do not contain code that can be effectively tested for code coverage). You can also define your custom inclusion/exclusion folders and files.

```xml
    <filter>
        <whitelist>
            <!-- The name of the folder to use for code coverage -->
            <directory suffix=".php">app/</directory>
            <exclude>
                <!-- Files/folders excluded from code coverage (PHP files without testable methods). Edit according to your project needs. -->
                <directory suffix=".php">app/models</directory>
                <directory suffix=".php">app/routes</directory>
            </exclude>
        </whitelist>
    </filter>
```

#### Writing the tests
All unit tests should be, by default, written inside the `tests/unit` directory. Test file names should end with `Test.php`, so that they are discoverable by PHPUnit (as defined in `phpunit.xml`), e.g. `SampleTest.php`.

A test class is defined as extending the `TestCase` class, and it can include various test methods. When naming the tests, you can use the following convention: `test` + description of the test in camel case (e.g. `testThisIsASampleTest`). This will allow the test case name to be converted to a descriptive sentence during test execution, giving additional overview to the developer about what the test should do.

```php
/* tests/unit/SampleTest.php */

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
PHPUnit 7.5.16 by Sebastian Bergmann and contributors.

Sample
 ✔ This is a sample test
```

To run only a single test file, supply its path: `vendor/bin/phpunit --testdox tests/unit/SampleTest.php` 

The flag `--testdox` is optional, but recommended, as it will generate descriptive sentences about the tests based on their names (as discussed in the section above), making it easier to understand what is going on inside the tests.

After executing the tests, the code coverage report is generated inside `tests/build/coverage` directory, and can be viewed by opening this path via a browser.

## Authors
- __Aldin Kovačević__, _initial work on the skeleton and documentation_ - [Aldin-SXR](https://github.com/Aldin-SXR)

## License
The skeleton is licensed under the [MIT](http://www.opensource.org/licenses/mit-license.php) license. See the [LICENSE](https://github.com/Aldin-SXR/flight-php-swagger/blob/master/LICENSE) file for details.

---

_Work in progress._ 