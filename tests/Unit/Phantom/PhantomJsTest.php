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
namespace Tests\Unit\Phantom;

use Tests\TestCase;

/**
 * @test
 * @covers  App\Utils\PhantomJS\Phantom
 */
class PhantomJsTest extends TestCase
{
    public function setUp() :void
    {
        parent::setUp();
    }

    public function testValidPdfMime()
    {
    	$pdf = file_get_contents(base_path('/tests/Unit/Phantom/valid.pdf'));

        $finfo = new \finfo(FILEINFO_MIME);

		$this->assertEquals('application/pdf; charset=binary', $finfo->buffer($pdf));

    }

    public function testInValidPdfMime()
    {

    	$pdf = file_get_contents(base_path('/tests/Unit/Phantom/invalid.pdf'));

        $finfo = new \finfo(FILEINFO_MIME);

		$this->assertNotEquals('application/pdf; charset=binary', $finfo->buffer($pdf));

    }

}
