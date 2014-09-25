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
 * @version    1.2.1
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2014, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Assetic\Asset\AssetInterface;
use Symfony\Component\HttpFoundation\Request;
use Assetic\Filter\LessphpFilter as AsseticLessphpFilter;

class LessphpFilter extends AsseticLessphpFilter {

	/**
	 * Symfony request instance.
	 *
	 * @var string
	 */
	protected $request;

	/**
	 * Filters an asset after it has been loaded.
	 *
	 * @param Assetic\Asset\AssetInterface $asset
	 */
	public function filterLoad(AssetInterface $asset)
	{
		$max_nesting_level = ini_get('xdebug.max_nesting_level');

		$memory_limit = ini_get('memory_limit');

		if ($max_nesting_level && $max_nesting_level < 200)
		{
			ini_set('xdebug.max_nesting_level', 200);
		}

		if ($memory_limit && $memory_limit < 256)
		{
			ini_set('memory_limit', '256M');
		}

		$root = $asset->getSourceRoot();
		$path = $asset->getSourcePath();

		$dirs = array();

		$lc = new \Less_Parser(array(
			'compress'     => true,
		));

		if ($root && $path)
		{
			$dirs[] = dirname($root.'/'.$path);
		}

		foreach ($this->loadPaths as $loadPath)
		{
			$dirs[] = $loadPath;
		}

		$lc->SetImportDirs($dirs);

		$url = parse_url($this->getRequest()->getUriForPath(''));

		$absolutePath = str_replace(public_path(), '', $root);

		if (isset($url['path']))
		{
			$absolutePath = $url['path'] . $absolutePath;
		}

		$lc->parseFile($root.'/'.$path, $absolutePath);

		$asset->setContent($lc->getCss());
	}

	/**
	 * Returns or creates a new symfony request.
	 *
	 * @return \Symfony\Component\HttpFoundation\Request
	 */
	public function getRequest()
	{
		return $this->request ?: $this->request = Request::createFromGlobals();
	}

	/**
	 * Sets the request instance.
	 *
	 * @param  \Symfony\Component\HttpFoundation\Request
	 * @return void
	 */
	public function setRequest($request)
	{
		$this->request = $request;
	}

}
