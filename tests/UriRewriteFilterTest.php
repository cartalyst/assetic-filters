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
