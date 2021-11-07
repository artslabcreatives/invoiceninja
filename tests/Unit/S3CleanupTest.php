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

use App\DataMapper\ClientSettings;
use Tests\TestCase;

/**
 * @test
 */
class S3CleanupTest extends TestCase
{
    public function setUp() :void
    {
        parent::setUp();
    }

    public function testMergeCollections()
    {
        $c1 = collect(["1","2","3","4"]);
        $c2 = collect(["5","6","7","8"]);

        $c3 = collect(["1","2","10"]);

        $merged = $c1->merge($c2)->toArray();

        $this->assertTrue(in_array("1", $merged));
        $this->assertFalse(in_array("10", $merged));
           
    }
}
