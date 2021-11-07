<?php

/**
 * Hype Sri Lanka (https://hypesl.org).
 *
 * @link https://github.com/artslabcreatives/invoiceninja source repository
 *
 * @copyright Copyright (c) 2021. Hype Sri Lanka (https://hypesl.org)
 *
 * @license https://opensource.org/licenses/AAL
 */

use App\Models\Gateway;
use Illuminate\Database\Migrations\Migration;

class ActivateGocardlessPaymentDriver extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $gateway = Gateway::find(52);

        if ($gateway) {
            $gateway->provider = 'GoCardless';
            $gateway->visible = true;
            $gateway->save();
        }
    }
}
