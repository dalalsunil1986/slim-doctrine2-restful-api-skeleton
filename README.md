# RESTful API skeleton using Slim 3, Doctrine 2 (MySQL), PHPUnit, Mockery
Single POST endpoint storing data via Doctrine 2, and unit test on the used service.

by Elvis Ciotti <elvisciotti@gmail.com>

### Requirements
* PHP 5.4 or above.
* Mysql at least v5.0 running (install with docker if not available, see section below).
 Any doctrine2-compatible database can be used instead, change config accordingly

### Setup and run

 * Permissions
 
        chmod +x composer vendor/bin/*
        chmod -R +w app/log/* app/cache/*
    
 * Set mysql connection data into `app/settings.php`
 * create database (example with `dbxyz` as a name)
 
        mysql -u root -p -e "CREATE DATABASE dbxyz;"
        mysql -u root -p -e "CREATE DATABASE dbxyz_test;"
 * Create schema using doctrine. 
 
        # create
        vendor/bin/doctrine orm:schema-tool:create
        # to drop (and test other fixtures with an empty db)
        vendor/bin/doctrine orm:schema-tool:drop --force

     In case of failures, check db connection settings

 * Run server `php -S localhost:8000`
 * keep log open in another window. 
 Set at `debug` level to see all the internal operations which any added record is logged.
 On production it'll be set to warning/error for better performances.
 
 
    `tail -f app/log/app.log`
    
 * add data
 
    # insert test file.json
    curl -X POST -d @app/fixtures/file.json http://localhost:8000/record
    
    # clean db
    vendor/bin/doctrine orm:schema-tool:drop --force
    vendor/bin/doctrine orm:schema-tool:create
    
    # run 2nd fixtures
    curl -X POST -d @app/fixtures/file.json http://localhost:8000/record

### How to run tests

    # unit test
    vendor/bin/phpunit tests/app/Service/
    
    # functional tests
    vendor/bin/phpunit tests/app/Integration/
    
    # all the above
    vendor/bin/phpunit

### Run mysql in a docker container, if not available

    docker run --name mysql -e MYSQL_ROOT_PASSWORD=123 -p 3306:3306 -d mysql:latest 
    docker exec -it mysql bash
    mysql -u root -p123
    # if alreay created
    docker start mysql

### TODO
* move routes to controller
* response listener for JSON input/output
* 

### Notes about architectural choices, frameworks and performances
 * There is a unit test using mocks for Doctrine, asserting that all the data gets saved into entities. 
 There also is a functional/integration test hitting the endpoint with a real request
 and also asserting that the data has been store into the test database
 Code is `app/routes.php`, `app/src` and tests under `tests`
 * Logger service, always a good practice to enable/disable and see what's happening.
 It can be set at different levels depending on the environment. Each single insert it logged.
  If kept at DEBUG level, it can be seen all the added data.
 * Mockery for testing, a mocking framework more suitable than PHPUnit mocks