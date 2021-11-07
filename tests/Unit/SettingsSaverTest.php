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

use App\DataMapper\CompanySettings;
use App\Utils\Traits\SettingsSaver;
use Tests\TestCase;

/**
 * @test
 */
class SettingsSaverTest extends TestCase
{
    use SettingsSaver;

    public function setUp() :void
    {
        parent::setUp();
    }

    public function testNullValueForStringTest()
    {
        $key = 'show_all_tasks_client_portal';
        $value = null;

        $result = $this->checkAttribute($key, $value);

        $this->assertFalse($result);

    }
}
