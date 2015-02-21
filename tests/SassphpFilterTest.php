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
 * @version    1.2.4
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Assetic\Asset\FileAsset;
use Cartalyst\AsseticFilters\SassphpFilter;
use PHPUnit_Framework_TestCase;

class SassphpFilterTest extends PHPUnit_Framework_TestCase {

	public function testCompilingWithImportPath()
	{
		$asset = new FileAsset(__DIR__.'/stubs/sass/style.sass');
		$asset->load();

		$filter = new SassphpFilter;
		$filter->addImportPath(__DIR__.'/stubs/sass/import_path');
		$filter->filterLoad($asset);

		$expected = file_get_contents(__DIR__.'/stubs/sass/style.css');

		$this->assertEquals($expected, $asset->getContent());
	}

}
