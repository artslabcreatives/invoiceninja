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
namespace Tests\Feature\PdfMaker;

use App\Services\PdfMaker\Design;
use App\Services\PdfMaker\PdfMaker;
use App\Utils\HtmlEngine;
use App\Utils\Traits\MakesInvoiceValues;
use Tests\MockAccountData;
use Tests\TestCase;

class ExampleIntegrationTest extends TestCase
{
    use MakesInvoiceValues, MockAccountData;

    public function setUp(): void
    {
        parent::setUp();

        $this->makeTestData();
    }

    public function testExample()
    {
        $this->markTestIncomplete();

        $invoice = $this->invoice;
        $invitation = $invoice->invitations()->first();

        $engine = new HtmlEngine($invitation);

        $design = new Design(
            Design::CLEAN
        );

        $state = [
            'template' => $design->elements([
                'client' => $invoice->client,
                'entity' => $invoice,
                'pdf_variables' => (array) $invoice->company->settings->pdf_variables,
            ]),
            'variables' => $engine->generateLabelsAndValues(),
        ];

        $maker = new PdfMaker($state);

        $maker
            ->design($design)
            ->build();

        //      exec('echo "" > storage/logs/laravel.log');

//        nlog($maker->getCompiledHTML(true));

        $this->assertTrue(true);
    }
}
