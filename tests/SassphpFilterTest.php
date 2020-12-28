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

use Assetic\Asset\FileAsset;
use PHPUnit\Framework\TestCase;
use Cartalyst\AsseticFilters\SassphpFilter;

class SassphpFilterTest extends TestCase
{
    public function testCompilingWithImportPath()
    {
        $asset = new FileAsset(__DIR__.'/stubs/sass/style.sass');
        $asset->load();

        $filter = new SassphpFilter();
        $filter->addImportPath(__DIR__.'/stubs/sass/import_path');
        $filter->filterLoad($asset);

        $expected = file_get_contents(__DIR__.'/stubs/sass/style.css');

        $this->assertSame($expected, $asset->getContent());
    }
}
