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
 * @version    6.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2022, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\AsseticFilters;

use Assetic\Asset\AssetInterface;
use Assetic\Filter\FilterInterface;
use Symfony\Component\HttpFoundation\Request;

/*
 * Credit for this filter goes to Jason Lewis, with his no longer maintained Basset package.
 *
 * @author    Jason Lewis
 * @link      <http://jasonlewis.me/code/basset>
 * @license   BSD-2-Clause
 * @package   Basset
 * @copyright 2012-2013 Jason Lewis
 */

/*
 * UriRewriteFilter is a rewrite and port of the popular CssUriRewrite class written by Steve Clay.
 * Original source can be found by following the links below.
 *
 * @author    Steve Clay
 * @link      <https://github.com/mrclay/minify>
 * @license   <https://github.com/mrclay/minify/blob/master/LICENSE.txt>
 * @package   Minify
 * @copyright 2008 Steve Clay / Ryan Grove
 */
class UriRewriteFilter implements FilterInterface
{
    /**
     * Applications document root. This is typically the public directory.
     *
     * @var string
     */
    protected $documentRoot;

    /**
     * The Symfony Request instance.
     *
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * Root directory of the asset.
     *
     * @var string
     */
    protected $assetDirectory;

    /**
     * Array of symbolic links.
     *
     * @var array
     */
    protected $symlinks;

    /**
     * Constructor.
     *
     * @param string $documentRoot
     * @param array  $symlinks
     *
     * @return void
     */
    public function __construct(string $documentRoot = '', array $symlinks = [])
    {
        $this->documentRoot = $this->realPath($documentRoot);

        $this->symlinks = $symlinks;
    }

    /**
     * Apply filter on file load.
     *
     * @param \Assetic\Asset\AssetInterface $asset
     *
     * @return void
     */
    public function filterLoad(AssetInterface $asset): void
    {
    }

    /**
     * Apply a filter on file dump.
     *
     * @param \Assetic\Asset\AssetInterface $asset
     *
     * @return void
     */
    public function filterDump(AssetInterface $asset): void
    {
        $this->assetDirectory = $this->realPath($asset->getSourceRoot());

        $content = $asset->getContent();

        // Spin through the symlinks and normalize them. We'll first unset the original
        // symlink so that it doesn't clash with the new symlinks once they are added
        // back in.
        foreach ($this->symlinks as $link => $target) {
            unset($this->symlinks[$link]);

            if ($link == '//') {
                $link = $this->documentRoot;
            } else {
                $link = str_replace('//', $this->documentRoot.'/', $link);
            }

            $link = strtr($link, '/', DIRECTORY_SEPARATOR);

            $this->symlinks[$link] = $this->realPath($target);
        }

        $content = $this->trimUrls($content);

        $content = preg_replace_callback('/@import\\s+([\'"])(.*?)[\'"]/', [$this, 'processUriCallback'], $content);

        $content = preg_replace_callback('/url\\(\\s*([^\\)\\s]+)\\s*\\)/', [$this, 'processUriCallback'], $content);

        $asset->setContent($content);
    }

    /**
     * Returns or creates a new symfony request.
     *
     * @return \Symfony\Component\HttpFoundation\Request
     */
    public function getRequest(): Request
    {
        if (! $this->request) {
            $this->request = Request::createFromGlobals();
        }

        return $this->request;
    }

    /**
     * Sets the request instance.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return void
     */
    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    /**
     * Takes a path and transforms it to a real path.
     *
     * @param string $path
     *
     * @return string
     */
    protected function realPath(string $path): string
    {
        if (php_sapi_name() == 'cli' && ! $path) {
            $path = $_SERVER['DOCUMENT_ROOT'];
        }

        if ($realPath = realpath($path)) {
            $path = $realPath;
        }

        return rtrim($path, '/\\');
    }

    /**
     * Trims URLs.
     *
     * @param string $content
     *
     * @return string
     */
    protected function trimUrls(string $content): string
    {
        return preg_replace('/url\\(\\s*([^\\)]+?)\\s*\\)/x', 'url($1)', $content);
    }

    /**
     * Processes a regular expression callback, determines the URI and returns the rewritten URIs.
     *
     * @param array $matches
     *
     * @return string
     */
    protected function processUriCallback(array $matches): string
    {
        $scriptName = basename($this->getRequest()->getScriptName());

        $isImport = $matches[0][0] === '@';

        // Determine what the quote character and the URI is, if there is one.
        $quoteCharacter = $uri = null;

        if ($isImport) {
            $quoteCharacter = $matches[1];

            $uri = $matches[2];
        } else {
            if ($matches[1][0] === "'" or $matches[1][0] === '"') {
                $quoteCharacter = $matches[1][0];
            }

            if (! $quoteCharacter) {
                $uri = $matches[1];
            } else {
                $uri = substr($matches[1], 1, strlen($matches[1]) - 2);
            }
        }

        // Strip off the scriptname
        $uri = str_replace($scriptName.'/', '', $uri);

        // Analyze the URI
        if ($uri[0] !== '/' and strpos($uri, '//') === false and strpos($uri, 'data') !== 0) {
            $uri = $this->rewriteAbsolute($uri);
        }

        if ($isImport) {
            return "@import {$quoteCharacter}{$uri}{$quoteCharacter}";
        }

        return "url({$quoteCharacter}{$uri}{$quoteCharacter})";
    }

    /**
     * Rewrites a relative URI.
     *
     * @param string $uri
     *
     * @return string
     */
    protected function rewriteAbsolute(string $uri): string
    {
        $request = $this->getRequest();

        $path = strtr($this->assetDirectory, '/', DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.strtr($uri, '/', DIRECTORY_SEPARATOR);

        foreach ($this->symlinks as $link => $target) {
            if (strpos($path, $target) === 0) {
                $path = $link.substr($path, strlen($target));

                break;
            }
        }

        $base = $_SERVER['REQUEST_URI'] ?? null;

        if ($request->getHost()) {
            $base = $request->getSchemeAndHttpHost().$request->getBaseUrl();
        }

        // Strip the document root from the path.
        if (strpos($path, app('path.public')) !== false) {
            $path = str_replace(app('path.public'), '', $path);
        } elseif (strpos($path, app('path.resources')) !== false) {
            $path = str_replace(app('path.resources'), '', $path);
        }

        $uri = strtr($path, '/\\', '//');
        $uri = $this->removeDots($uri);

        return $uri;
    }

    /**
     * Removes dots from a URI.
     *
     * @param string $uri
     *
     * @return string
     */
    protected function removeDots(string $uri): string
    {
        $uri = str_replace('/./', '/', $uri);

        do {
            $uri = preg_replace('@/[^/]+/\\.\\./@', '/', $uri, 1, $changed);
        } while ($changed);

        return $uri;
    }
}
