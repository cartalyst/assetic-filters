# Installation

The best and easiest way to install the Cart package is with [Composer](http://getcomposer.org).

## Preparation

Open your `composer.json` file and add the following to the `require` array:

	"cartalyst/assetic-filters": "1.0.*"

Add the following lines after the `require` array on your `composer.json` file:

	"repositories": [
		{
			"type": "composer",
			"url": "http://packages.cartalyst.com"
		}
	]

> **Note:** Make sure your `composer.json` file is in a valid JSON format after applying the required changes.<br>
*You can use the [JSONLint](http://jsonlint.com/) online tool to validate your `composer.json` file.*

## Install the dependencies

Run Composer to install or update the new requirement.

	php composer install

or

	php composer update

Now you are able to require the `vendor/autoload.php` file to autoload the package.
