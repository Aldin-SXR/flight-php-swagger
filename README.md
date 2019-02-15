# [WIP] Flight/Swagger bundle
[Flight PHP](http://flightphp.com/) micro-framework bundled with [Swagger](http://zircote.com/swagger-php/), [PHPUnit](https://phpunit.de/) and other useful utilities.
Designed to help kick-start the development of APIs built with the aforementioned tools by including the basic project setup, test routes and models, as well as the template for unit tests.

## Getting Started

### Prerequisites
This guides assumes that you are currently using (or planning to use) the following technologies in your project:
- PHP 7.1+
- [Composer](https://getcomposer.org/)

### Installing
1. First, make sure that you have installed and configured a running web server (such as Apache) with 7.1 or higher. Moreover, 
2. Use `composer` to download the project skeleton, install all required dependencies, and run the sample unit tests:

`composer create-project tribeos/flight-php-swagger path/to/project -s dev`

3. After the installation process finishes, confirm the removal of `VCS` data by confirming the following inquiry via `Y`:

`Do you want to remove the existing VCS (.git, .svn..) history? [Y,n]? Y`

### Project Structure
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

### Working on the project

#### Swagger-PHP
After creating a route in the `routes` folder, you can begin writing and generating [OpenAPI](https://www.openapis.org) documentation for your RESTful API.

Documentation is written inside _DocBlocks_, a.k.a PHP comment blocks, above the corresponding route.  
```php
/** 
 * @OA\Get(
 *      path="/wallet/generate",
 *      tags={"wallet"},
 *      summary="Generate a fresh Bitcoin Cash private key.",
 *      @OA\Response(
 *           response=200,
 *           description="Returns a Bitcoin Cash private key in WIF-format"
 *      ),
 *     security={
 *          {"api_key": {}}
 *      }
 * )
*/
```
You can define the path, tags, short summary, parameters, request body, available responses, security authentication and numerous other options for every RESTful endpoint. 

For more information about Swagger in general, and the OpenAPI standard, refer to [Swagger official homepage](https://swagger.io/). 
Extensive usage documentation and examples regarding the PHP implementation are available on the [swagger-php official homepage](http://zircote.com/swagger-php/). 

## Authors
- __Aldin Kovačević__ - _initial work_ - [Aldin-SXR](https://github.com/Aldin-SXR)

## License
The skeleton is licensed under the [MIT](http://www.opensource.org/licenses/mit-license.php) license.

---
_Work in progress._ 