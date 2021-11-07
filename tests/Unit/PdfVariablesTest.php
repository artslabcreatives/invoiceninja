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
use Tests\TestCase;

/**
 * @test
 */
class PdfVariablesTest extends TestCase
{
    public function setUp() :void
    {
        parent::setUp();

        $this->settings = CompanySettings::defaults();
    }

    public function testPdfVariableDefaults()
    {
        $this->assertTrue(is_array($this->settings->pdf_variables->client_details));
    }
}
