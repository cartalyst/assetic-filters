<?php namespace Cartalyst\AsseticFilters;
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

use Assetic\Asset\AssetInterface;
use Assetic\Filter\FilterInterface;
use CoffeeScript\Compiler;

class CoffeeScriptphpFilter implements FilterInterface {

	/**
	 * Sassphp preset options.
	 *
	 * @var array
	 */
	protected $presets = array();

	/**
	 * Filters an asset after it has been loaded.
	 *
	 * @param Assetic\Asset\AssetInterface $asset
	 */
	public function filterLoad(AssetInterface $asset)
	{
		$root    = $asset->getSourceRoot();
		$path    = $asset->getSourcePath();
		$presets = $this->presets;

		// If we have a root and path, set the 'file'
		// preset now, which aids in debugging should
		// something go wrong.
		if ($root and $path)
		{
			$presets = array_merge($presets, array(
				'file' => $root.'/'.$path,
			));
		}

		$asset->setContent(Compiler::compile($asset->getContent(), $presets));
	}

	/**
	 * Filters an asset just before it's dumped.
	 *
	 * @param Assetic\Asset\AssetInterface $asset
	 */
	public function filterDump(AssetInterface $asset)
	{

	}

	/**
	 * Sets the presets used by the filter.
	 *
	 * @param  array  $presets
	 * @return void
	 */
	public function setPresets(array $presets)
	{
		$this->presets = $presets;
	}

}
