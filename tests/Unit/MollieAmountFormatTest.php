<?php

/**
 * Hype Sri Lanka (https://hypesl.org).
 *
 * @link https://github.com/artslabcreatives/invoiceninja source repository
 *
 * @copyright Copyright (c) 2021. Hype Sri Lanka LLC (https://hypesl.org)
 *
 * @license https://www.elastic.co/licensing/elastic-license
 */

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class MollieAmountFormatTest extends TestCase
{
    /**
     * @covers \App\PaymentDrivers\MolliePaymentDriver::convertToMollieAmount() 
     */
    public function testFormatterIsWorkingCorrectly()
    {
        $this->assertEquals('1000.00', \number_format((float) 1000, 2, '.', ''));

        $this->assertEquals('1000.00', \number_format((float) "1000", 2, '.', ''));

        $this->assertEquals('1000.00', \number_format((float) "1000.00", 2, '.', ''));

        $this->assertEquals('1000.00', \number_format((float) "1000.00000", 2, '.', ''));
    }
}
