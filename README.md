exam-php
========

Currently in development. To be documented.

Testing
--------
Tests are built with PHPUnit.

Make sure you install with dev requirements.

	composer install

Go to the root of the project then run all tests by typing in the terminal:

	phpunit --bootstrap vendor/autoload.php tests/
	
With coverage report:

	phpunit --coverage-html ./tests/report --bootstrap vendor/autoload.php tests/
	
Last test run with with PHPUnit 4.1.4.
