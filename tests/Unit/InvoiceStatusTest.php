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

use App\Factory\InvoiceItemFactory;
use App\Helpers\Invoice\InvoiceSum;
use App\Models\Invoice;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\MockAccountData;
use Tests\TestCase;

/**
 * @test
 * @covers  App\Helpers\Invoice\InvoiceSum
 */
class InvoiceStatusTest extends TestCase
{
    use MockAccountData;
    use DatabaseTransactions;

    public $invoice;

    public $invoice_calc;

    public $settings;

    public function setUp() :void
    {
        parent::setUp();

        $this->makeTestData();

    }

    public function testSentStatus()
    {
        $this->invoice->due_date = now()->addMonth();
        $this->invoice->status_id = Invoice::STATUS_SENT;

        $this->assertEquals(Invoice::STATUS_UNPAID, $this->invoice->getStatusAttribute());
    }

    public function testPartialStatus()
    {
        $this->invoice->partial_due_date = now()->addMonth();
        $this->invoice->status_id = Invoice::STATUS_SENT;

        $this->assertEquals(Invoice::STATUS_SENT, $this->invoice->getStatusAttribute());
    }
}
