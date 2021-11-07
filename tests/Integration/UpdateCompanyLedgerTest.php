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
namespace Tests\Integration;

use App\Models\CompanyLedger;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\MockAccountData;
use Tests\TestCase;

/** @test*/
class UpdateCompanyLedgerTest extends TestCase
{
    use MockAccountData;
    use DatabaseTransactions;

    public function setUp() :void
    {
        parent::setUp();

        $this->makeTestData();
    }

    /**
     * @test
     */
    public function testPaymentIsPresentInLedger()
    {
        $invoice = $this->invoice->service()->markPaid()->save();

        $ledger = CompanyLedger::whereClientId($invoice->client_id)
                                ->whereCompanyId($invoice->company_id)
                                ->orderBy('id', 'DESC')
                                ->first();

        $payment = $ledger->adjustment * -1;
        $this->assertEquals($invoice->amount, $payment);
    }

    /**
     * @test
     */
    public function testInvoiceIsPresentInLedger()
    {
        $invoice = $this->invoice->service()->markPaid()->save();

        $this->assertGreaterThan(0, $invoice->company_ledger()->count());
    }
}
