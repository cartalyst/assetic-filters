<?php

/*
 * Part of the Assetic Filters package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Assetic Filters
 * @version    5.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2020, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\AsseticFilters\Tests;

use Mockery as m;
use Assetic\Asset\StringAsset;
use Orchestra\Testbench\TestCase;
use Cartalyst\AsseticFilters\UriRewriteFilter;

class UriRewriteFilterTest extends TestCase
{
    public function testUriRewriteWithImport()
    {
        $input = "@import 'foobar.css';";

        $asset = new StringAsset($input, [], 'http://example.com/baz', 'qux.css');
        $asset->load();

        $filter = new UriRewriteFilter('path/to/public', []);
        $filter->filterDump($asset);

        $this->assertSame('@import \'http://example.com/baz/foobar.css\';', $asset->getContent());
    }

    public function testUriRewrite()
    {
        $input = "body { background-image: url('../foo/bar.png'); }";

        $asset = new StringAsset($input, [], 'http://example.com/baz', 'qux.css');
        $asset->load();

        $filter = new UriRewriteFilter('path/to/public', []);
        $filter->filterDump($asset);

        $this->assertSame("body { background-image: url('http://example.com/foo/bar.png'); }", $asset->getContent());
    }

    public function testUriRewriteWithSymlinks()
    {
        $filter = new UriRewriteFilter('path/to/public', ['//assets' => strtr('path/to/outside/public/assets', '/', DIRECTORY_SEPARATOR)]);

        $input = "body { background-image: url('../foo/bar.png'); }";

        $asset = new StringAsset($input, [], 'http://example.com/assets/baz', 'qux.css');
        $asset->load();

        $filter->filterDump($asset);

        $this->assertSame("body { background-image: url('http://example.com/assets/foo/bar.png'); }", $asset->getContent());
    }

    public function testUriRewriteWithSymlinksAndSubDir()
    {
        $input = "body { background-image: url('../foo/bar.png'); }";

        $request = m::mock('Symfony\Component\HttpFoundation\Request');
        $request->shouldReceive('getScriptName')->once()->andReturn('/index.php');
        $request->shouldReceive('getHost')->once();

        $asset = new StringAsset($input, [], 'http://example.com/assets/baz', 'qux.css');
        $asset->load();

        $filter = new UriRewriteFilter('path/to/public', ['//assets' => strtr('path/to/outside/public/assets', '/', DIRECTORY_SEPARATOR)]);
        $filter->setRequest($request);
        $filter->filterDump($asset);

        $this->assertSame("body { background-image: url('http://example.com/assets/foo/bar.png'); }", $asset->getContent());
    }
}
