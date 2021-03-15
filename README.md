Assessment API app
=============

Requirements
------------------------

    1. docker
    
    or 
    
    1. PHP 7.4+
    2. Apache or Nginx
    3. composer
    

Install
------------------------

    1. docker-compose up
    2. docker exec -i time-tracking_php_1 sh < update.sh
    
    or 
    
    1. PHP 7.4+
    3. Apache or Nginx
    4. Set up your config
    4, ./update.sh


Run UnitTest
------------------------

php -d memory_limit=-1 vendor/bin/phpunit -c phpunit.xml.dist --no-coverage --no-logging


