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

use Tests\TestCase;

class SentryTest extends TestCase
{
    public function testSentryFiresAppropriately()
    {
        $e = new \Exception('Test Fire');
        app('sentry')->captureException($e);

        $this->assertTrue(true);
    }
}
