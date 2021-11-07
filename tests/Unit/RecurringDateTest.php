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

use App\Models\Invoice;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Carbon;
use Tests\MockAccountData;
use Tests\TestCase;

/**
 * @test
 */
class RecurringDateTest extends TestCase
{
    use DatabaseTransactions;
    use MockAccountData;

    public function setUp() :void
    {
        parent::setUp();

        //$this->makeTestData();
    }

    public function testNextDay()
    {
    	$trial = 60*60*24;

    	$now = Carbon::parse('2021-12-01');

    	$trial_ends = $now->addSeconds($trial)->addDays(1);

    	$this->assertequals($trial_ends->format('Y-m-d'), '2021-12-03');
    }
}