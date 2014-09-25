<?php namespace Cartalyst\AsseticFilters\Tests;
/**
 * Part of the Assetic Filters package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the license.txt file.
 *
 * @package    Assetic Filters
 * @version    1.2.2
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2014, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Assetic\Asset\FileAsset;
use Cartalyst\AsseticFilters\CoffeeScriptphpFilter;
use PHPUnit_Framework_TestCase;

class CoffeeScriptphpFilterTest extends PHPUnit_Framework_TestCase {

	public function testCompilation()
	{
		$asset = new FileAsset(__DIR__.'/stubs/coffeescript/script.coffee');
		$asset->load();

		$filter = new CoffeeScriptphpFilter;
		$filter->filterLoad($asset);

		$expected = file_get_contents(__DIR__.'/stubs/coffeescript/script.js');

		$this->assertEquals($expected, $asset->getContent());
	}

}
