# DocDocDoc
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Travis](https://img.shields.io/travis/futurfuturfutur/docdocdoc.svg?style=flat-square)]()
[![Total Downloads](https://img.shields.io/packagist/dt/futurfuturfutur/docdocdoc.svg?style=flat-square)](https://packagist.org/packages/futurfuturfutur/docdocdoc)
<br>
Laravel package able to auto generate API documentation through tests, without garbage comments inside the code base.
## Install
1. Install package with `composer require futurfuturfutur/docdocdoc`
2. Publish and setup package with `php artisan docdocdoc:init`.
3. Add DocDocDocTestCase trait inside the phpunit TestCase 
    ``` php
    <?php
    
    namespace Tests;
    
    use Futurfuturfutur\Docdocdoc\Traits\DocDocDocTestCase;
    use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
    
    abstract class TestCase extends BaseTestCase
    {
        use CreatesApplication;
        use DocDocDocTestCase;
    }
    ```
4. Setup `DOCDOCDOC_MODE_ON` variable to `TRUE` inside your `.env` config of environment which where you will run tests 
and generate documentation. By default, it is `FALSE`.

## Usage
### Setup
The package will handle most of the things, but some of them you need to define by yourself:
1. Route summery, description, group and, in case an action of the route has not-method-injected request - request class,
 should be defined as PHPDoc comment of the class of the test (All of them are optional):
    ``` php
    /**
     * @DocDocDocRouteGroup Group name
     * @DocDocDocRouteSummery Summery
     * @DocDocDocRouteDescription Description
     * @DocDocDocRouteRequest App\Requests\TestFormRequest
     */
   class IndexTest extends TestCase
   {
    ```
2. A test case description should be defined as PHPDoc comment of the case method:
    ``` php
    /**
     * @DocDocDocRouteDescription Description of the case
     */
    public function testShow()
    {
    ```
3. Define base info of the application documentation (name, description, type of documentation, version) inside the `config/docdocdoc.php`
### Run build
You can just run your tests with `php artisan test`, package will generate documentation
 file inside the `/storage/app/docdocdoc` folder. Config contains:
 * Base info about documentation
 * Grouped paths with descriptions and methods
 * Path, query and body parameters from request
 * Responses for the route with payloads and codes
 * Validation rules for request parameters  (to do)

### Render service
Package contains ready to go docker-compose for api documentation renderers
##### Swagger
1. Publish swagger render configuration with `php artisan docdocdoc:render swagger`. This command will publish  `docker-compose.swagger.yaml` configuration in root of the app.
2. In the root of the app run render with `docker-compose -f docker-compose.swagger.yml up --build -d`.
3. Swagger API documentation is up on the `localhost:9191`. If you want to change default `9191` port edit `docker-compose.swagger.yaml` configuration file.


## Contributing
Please see [Contribution](CONTRIBUTING.md) for details.


## License
The MIT License (MIT). Please see [License File](/LICENSE.md) for more information.
