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

namespace Tests\Browser\ClientPortal\Gateways\Mollie;

use App\Models\CompanyGateway;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\Browser\Pages\ClientPortal\Login;

class KBCTest extends DuskTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        foreach (static::$browsers as $browser) {
            $browser->driver->manage()->deleteAllCookies();
        }

        $this->disableCompanyGateways();

        CompanyGateway::where('gateway_key', '1bd651fb213ca0c9d66ae3c336dc77e8')->restore();

        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Login())
                ->auth();
        });
    }

    public function testSuccessfulPayment(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visitRoute('client.invoices.index')
                ->click('@pay-now')
                ->press('Pay Now')
                ->clickLink('Undefined.')
                ->waitForText('Test profile')
                ->press('CBC')
                ->radio('final_state', 'paid')
                ->press('Continue')
                ->waitForText('Details of the payment')
                ->assertSee('Completed');
        });
    }

    public function testFailedPayment(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visitRoute('client.invoices.index')
                ->click('@pay-now')
                ->press('Pay Now')
                ->clickLink('Undefined.')
                ->waitForText('Test profile')
                ->press('CBC')
                ->radio('final_state', 'failed')
                ->press('Continue')
                ->waitForText('Failed.');
        });
    }

    public function testCancelledTest(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visitRoute('client.invoices.index')
                ->click('@pay-now')
                ->press('Pay Now')
                ->clickLink('Undefined.')
                ->waitForText('Test profile')
                ->press('CBC')
                ->radio('final_state', 'canceled')
                ->press('Continue')
                ->waitForText('Cancelled.');
        });
    }
}