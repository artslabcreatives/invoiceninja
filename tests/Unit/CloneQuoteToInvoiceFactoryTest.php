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

use App\Factory\CloneQuoteToInvoiceFactory;
use App\Models\Invoice;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\MockAccountData;
use Tests\TestCase;

/**
 * @test
 */
class CloneQuoteToInvoiceFactoryTest extends TestCase
{
    use MockAccountData;
    use DatabaseTransactions;

    public function setUp() :void
    {
        parent::setUp();

        $this->makeTestData();
    }

    public function testCloneProperties()
    {
        $invoice = CloneQuoteToInvoiceFactory::create($this->quote, $this->quote->user_id);

        $this->assertNull($invoice->due_date);
        $this->assertNull($invoice->partial_due_date);
        $this->assertNull($invoice->number);
    }

    public function testQuoteToInvoiceConversionService()
    {
        $invoice = $this->quote->service()->convertToInvoice();

        $this->assertTrue($invoice instanceof Invoice);
    }
}
