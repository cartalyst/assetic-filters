## Usage

### CoffeeScript PHP Compiler

Currently, compiling CoffeeScript requires that you install [NodeJS](http://nodejs.org) and then CoffeeScript through `sudo npm install -g coffee-script`.

This is a relatively easy process, providing you have good access to the server. But what if you just wanted to get up and running without mucking around with external libraries? We have you covered. Simply return an instance of `Cartalyst\AsseticFilters\CoffeeScriptphpFilter` to your filters in assetic and you're done!

### SASS PHP Compiler

Like the logic behind CoffeeScript, we would like people to get up and running with the predecessor to [SCSS, known as SASS](http://sass-lang.com) with ease. Rather than install a ruby gem, simply pass an instance of `Cartalyst\AsseticFilters\SassphpFilter` to your assetic filters and you're done.

### LESS PHP Compiler

Like the logic behind CoffeeScript, we would like people to get up and running with [LESS](http://lesscss.org) with ease. Rather than install a ruby gem, simply pass an instance of `Cartalyst\AsseticFilters\LessphpFilter` to your assetic filters and you're done.
