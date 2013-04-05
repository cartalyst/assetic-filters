### Assetic Filters

Our assetic filters are a (growing) list of filters which enhance Assetic and can make your job easier as a developer, meaning you can get home earlier. Good, right?

We currently have the following filters:

1. [CoffeeScript PHP Compiler](#coffeescript-php-compiler)
2. [SASS PHP Compiler](#sass-php-compiler)

Installation of our assetic filters is easy. Simply ensure your `composer.json` file has the following structure:

	{
		"repositories": [
			{
				"type": "composer",
				"url": "http://packages.cartalyst.com"
			}
		],
		"require": {
			"cartalyst/assetic-filters": "1.0.*"
		}
	}

### CoffeeScript PHP Compiler

Currently, compiling CoffeeScript requires that you install [NodeJS](http://nodejs.org) and then CoffeeScript through `sudo npm install -g coffee-script`.

This is a relatively easy process, providing you have good access to the server. But what if you just wanted to get up and running without mucking around with external libraries? We have you covered. Simply return an instance of `Cartalyst\AsseticFilters\CoffeeScriptphpFilter` to your filters in assetic and you're done!

### SASS PHP Compiler

Like the logic behind CoffeeScript, we would like people to get up and running with the predecessor to [SCSS, known as SASS](http://sass-lang.com) with ease. Rather than install a ruby gem, simply pass an instance of `Cartalyst\AsseticFilters\SassphpFilter` to your assetic filters and you're done.
