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

use App\Models\Timezone;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Running DatabaseSeeder');

        if (Timezone::count()) {
            $this->command->info('Skipping: already run');

            return;
        }

        Model::unguard();

        $this->call([
            ConstantsSeeder::class,
            PaymentLibrariesSeeder::class,
            BanksSeeder::class,
            CurrenciesSeeder::class,
            LanguageSeeder::class,
            CountriesSeeder::class,
            IndustrySeeder::class,
            PaymentTypesSeeder::class,
            GatewayTypesSeeder::class,
            DateFormatsSeeder::class,
            DesignSeeder::class,
        ]);
    }
}
