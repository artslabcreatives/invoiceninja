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
namespace Tests\Feature\Export;

use App\Jobs\Company\CompanyExport;
use App\Models\Invoice;
use App\Utils\Traits\MakesHash;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Support\Facades\Storage;
use League\Csv\Writer;
use Tests\MockAccountData;
use Tests\TestCase;

/**
 * @test
 */
class ExportCompanyTest extends TestCase
{
    use MakesHash;
    use MockAccountData;

    public function setUp() :void
    {
        parent::setUp();

        $this->withoutMiddleware(
            ThrottleRequests::class
        );

        // $this->faker = \Faker\Factory::create();

        $this->makeTestData();

        $this->withoutExceptionHandling();

        if (! config('ninja.testvars.stripe')) {
            $this->markTestSkipped('Cannot write to TMP - skipping');
        }
    }

    public function testCompanyExport()
    {
        $res = CompanyExport::dispatchNow($this->company, $this->company->users->first());

        $this->assertTrue($res);
    }
}
