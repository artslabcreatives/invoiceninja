<?php
/**
 * Hype Sri Lanka (https://hypesl.org).
 *
 * @link https://github.com/artslabcreatives/invoiceninja source repository
 *
 * @copyright Copyright (c) 2021. Hype Sri Lanka LLC (https://hypesl.org)
 *
 * @license https://opensource.org/licenses/AAL
 */
namespace Tests\Unit;

use Tests\TestCase;

/**
 * @test
 */
class UrlTest extends TestCase
{

   	public function setUp() :void
    {
        parent::setUp();
    }

    public function testNoScheme()
    {
    	$url = 'google.com';

    	$this->assertEquals("https://google.com", $this->addScheme($url));
    }

    public function testNoSchemeAndTrailingSlash()
    {
    	$url = 'google.com/';

    	$this->assertEquals("https://google.com", $this->addScheme($url));
    }


    public function testNoSchemeAndTrailingSlashAndHttp()
    {
    	$url = 'http://google.com/';

    	$this->assertEquals("https://google.com", $this->addScheme($url));
    }

	private function addScheme($url, $scheme = 'https://')
	{

	  $url = str_replace("http://", "", $url);

	  $url =  parse_url($url, PHP_URL_SCHEME) === null ? $scheme . $url : $url;

	  return rtrim($url, '/');

	}

}