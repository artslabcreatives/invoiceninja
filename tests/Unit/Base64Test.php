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

use App\Utils\Ninja;
use Tests\TestCase;

/**
 * @test
 */
class Base64Test extends TestCase
{
    /**
     * Important consideration with Base64
     * encoding checks.
     *
     * No method can guarantee against false positives.
     */
    public function setUp() :void
    {
        parent::setUp();
    }

    public function testBadBase64String()
    {
        $this->assertFalse(Ninja::isBase64Encoded('x'));
    }

    public function testCorrectBase64Encoding()
    {
        $this->assertTrue(Ninja::isBase64Encoded('MTIzNDU2'));
    }

    public function testBadBase64StringScenaro1()
    {
        $this->assertFalse(Ninja::isBase64Encoded('Matthies'));
    }

    public function testBadBase64StringScenaro2()
    {
        $this->assertFalse(Ninja::isBase64Encoded('Barthels'));
    }

    public function testBadBase64StringScenaro3()
    {
        $this->assertFalse(Ninja::isBase64Encoded('aaa'));
    }

}