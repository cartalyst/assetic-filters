<?php namespace Cartalyst\AsseticFilters\Tests;
/**
 * Part of the Assetic Filters Package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Assetic Filters
 * @version    2.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2013, Cartalyst LLC
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
