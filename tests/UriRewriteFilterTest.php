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
 * @version    1.2.1
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2014, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Assetic\Asset\StringAsset;
use Cartalyst\AsseticFilters\UriRewriteFilter;
use PHPUnit_Framework_TestCase;

class UriRewriteFilterTest extends PHPUnit_Framework_TestCase {


    public function testUriRewrite()
    {
        $filter = new UriRewriteFilter('path/to/public');

        $input = "body { background-image: url('../foo/bar.png'); }";

        $asset = new StringAsset($input, array(), 'path/to/public/baz', 'qux.css');
        $asset->load();

        $filter->filterDump($asset);

        $this->assertEquals("body { background-image: url('/foo/bar.png'); }", $asset->getContent());
    }


    public function testUriRewriteWithSymlinks()
    {
        $filter = new UriRewriteFilter('path/to/public', array('//assets' => strtr('path/to/outside/public/assets', '/', DIRECTORY_SEPARATOR)));
        $input = "body { background-image: url('../foo/bar.png'); }";


        $asset = new StringAsset($input, array(), 'path/to/outside/public/assets/baz', 'qux.css');
        $asset->load();

        $filter->filterDump($asset);

        $this->assertEquals("body { background-image: url('/assets/foo/bar.png'); }", $asset->getContent());
    }


}
