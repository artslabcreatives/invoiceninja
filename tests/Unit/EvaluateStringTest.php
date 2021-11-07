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

use App\Models\Client;
use Tests\TestCase;

/**
 * @test
 */
class EvaluateStringTest extends TestCase
{
    public function testClassNameResolution()
    {
        $this->assertEquals(class_basename(Client::class), 'Client');
    }
}
