<?php namespace Cartalyst\AsseticFilters;
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
 * @version    1.2.3
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Assetic\Asset\AssetInterface;
use Assetic\Filter\FilterInterface;

class SassphpFilter implements FilterInterface {

	/**
	 * Sassphp preset options.
	 *
	 * @var array
	 */
	protected $presets = array();

	/**
	 * Sassphp import paths.
	 *
	 * @var array
	 */
	protected $importPaths = array();

	/**
	 * Filters an asset after it has been loaded.
	 *
	 * @param Assetic\Asset\AssetInterface $asset
	 */
	public function filterLoad(AssetInterface $asset)
	{
		$root = $asset->getSourceRoot();
		$path = $asset->getSourcePath();

		$compiler = new \SassParser($this->presets);

		if ($root and $path)
		{
			$compiler->load_paths = array_merge($compiler->load_paths, array($root.'/'.$path));
		}

		$compiler->load_paths = array_merge($compiler->load_paths, $this->importPaths);

		$asset->setContent($compiler->toCss($asset->getContent(), false));
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
	public function setPreset(array $presets)
	{
		$this->presets = $presets;
	}

	/**
	 * Sets the import paths used by the filter.
	 *
	 * @param  string  $presets
	 * @return void
	 */
	public function setImportPaths(array $paths)
	{
		$this->importPaths = $paths;
	}

	/**
	 * Appends a new import path.
	 *
	 * @param  string  $path
	 * @return void
	 */
	public function addImportPath($path)
	{
		$this->importPaths[] = $path;
	}

}
