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

use App\Jobs\Entity\CreateEntityPdf;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\MockAccountData;
use Tests\TestCase;

/**
 * @test
 * @covers App\Services\Invoice\GetInvoicePdf
 */
class InvoiceUploadTest extends TestCase
{
    use MockAccountData;
    use DatabaseTransactions;

    public function setUp() :void
    {
        parent::setUp();

        $this->makeTestData();
    }

    public function testInvoiceUploadWorks()
    {
        CreateEntityPdf::dispatchNow($this->invoice->invitations->first());

        $this->assertNotNull($this->invoice->service()->getInvoicePdf($this->invoice->client->primary_contact()->first()));
    }
}
