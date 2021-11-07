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

namespace Tests\Pdf;

use Beganovich\Snappdf\Snappdf;
use Tests\TestCase;

/**
 * @test
 //@covers  App\DataMapper\BaseSettings
 */
class PdfGenerationTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testPdfGeneration()
    {
        $pdf = new Snappdf();

        if (config('ninja.snappdf_chromium_path')) {
            $pdf->setChromiumPath(config('ninja.snappdf_chromium_path'));
        }

        if (config('ninja.snappdf_chromium_arguments')) {
            $pdf->clearChromiumArguments();
            $pdf->addChromiumArguments(config('ninja.snappdf_chromium_arguments'));
        }

        $pdf = $pdf
            ->setHtml('<h1>Hype Sri Lanka</h1>')
            ->generate();

        $this->assertNotNull($pdf);
    }
}
