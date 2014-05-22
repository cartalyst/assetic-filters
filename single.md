<h1>Introduction</h1>

<p>Our assetic filters are a (growing) list of filters which enhance Assetic and can make your job easier as a developer, meaning you can get home earlier. Good, right?</p>

<p>We currently have the following filters:</p>

<ol>
<li><a href="#coffeescript-php-compiler">CoffeeScript PHP Compiler</a></li>
<li><a href="#sass-php-compiler">SASS PHP Compiler</a></li>
<li><a href="#less-php-compiler">LESS PHP Compiler</a></li>
</ol><h1>Usage</h1>

<h2>CoffeeScript PHP Compiler</h2>

<p>Currently, compiling CoffeeScript requires that you install <a href="http://nodejs.org">NodeJS</a> and then CoffeeScript through <code>sudo npm install -g coffee-script</code>.</p>

<p>This is a relatively easy process, providing you have good access to the server. But what if you just wanted to get up and running without mucking around with external libraries? We have you covered. Simply return an instance of <code>Cartalyst\AsseticFilters\CoffeeScriptphpFilter</code> to your filters in assetic and you're done!</p>

<h2>SASS PHP Compiler</h2>

<p>Like the logic behind CoffeeScript, we would like people to get up and running with the predecessor to <a href="http://sass-lang.com">SCSS, known as SASS</a> with ease. Rather than install a ruby gem, simply pass an instance of <code>Cartalyst\AsseticFilters\SassphpFilter</code> to your assetic filters and you're done.</p>

<h2>LESS PHP Compiler</h2>

<p>Like the logic behind CoffeeScript, we would like people to get up and running with <a href="http://lesscss.org">LESS</a> with ease. Rather than install a ruby gem, simply pass an instance of <code>Cartalyst\AsseticFilters\LessphpFilter</code> to your assetic filters and you're done.</p>