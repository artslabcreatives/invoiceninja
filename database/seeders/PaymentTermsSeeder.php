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
namespace Database\Seeders;

use App\Models\PaymentTerm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class PaymentTermsSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $paymentTerms = [
            ['num_days' => 0, 'name' => 'Net 0'],
            ['num_days' => 7,  'name'  => ''],
            ['num_days' => 10, 'name' => ''],
            ['num_days' => 14, 'name' => ''],
            ['num_days' => 15, 'name' => ''],
            ['num_days' => 30, 'name' => ''],
            ['num_days' => 60, 'name' => ''],
            ['num_days' => 90, 'name' => ''],
        ];

        foreach ($paymentTerms as $paymentTerm) {
            PaymentTerm::create($paymentTerm);
        }
    }
}
