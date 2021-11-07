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

namespace Tests\Feature\ClientPortal;

use App\DataMapper\ClientSettings;
use App\DataMapper\CompanySettings;
use App\Http\Livewire\CreditsTable;
use App\Models\Account;
use App\Models\Client;
use App\Models\ClientContact;
use App\Models\Company;
use App\Models\Credit;
use App\Models\User;
use App\Utils\Traits\AppSetup;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;
use function now;

class CreditsTest extends TestCase
{
    use DatabaseTransactions;
    use AppSetup;
    
    public function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
        $this->buildCache(true);
    }

    public function testShowingOnlyCreditsWithDueDateLessOrEqualToNow()
    {
        $account = Account::factory()->create();

        $user = User::factory()->create(
            ['account_id' => $account->id, 'email' => $this->faker->safeEmail]
        );

        $company = Company::factory()->create(['account_id' => $account->id]);
        $company->settings = CompanySettings::defaults();
        $company->save();

        $client = Client::factory()->create(['company_id' => $company->id, 'user_id' => $user->id]);
        $client->settings = ClientSettings::defaults();
        $client->save();

        ClientContact::factory()->count(2)->create([
            'user_id' => $user->id,
            'client_id' => $client->id,
            'company_id' => $company->id,
        ]);

        Credit::factory()->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'client_id' => $client->id,
            'number' => 'testing-number-01',
            'due_date' => now()->subDays(5),
            'status_id' => Credit::STATUS_SENT,
        ]);

        Credit::factory()->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'client_id' => $client->id,
            'number' => 'testing-number-02',
            'due_date' => now(),
            'status_id' => Credit::STATUS_SENT,
        ]);

        Credit::factory()->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'client_id' => $client->id,
            'number' => 'testing-number-03',
            'due_date' => now()->addDays(5),
            'status_id' => Credit::STATUS_SENT,
        ]);

        $this->actingAs($client->contacts->first(), 'contact');

        Livewire::test(CreditsTable::class, ['company' => $company])
            ->assertDontSee('testing-number-01')
            ->assertSee('testing-number-02')
            ->assertSee('testing-number-03');
    }

    public function testShowingCreditsWithNullDueDate()
    {
        $account = Account::factory()->create();

        $user = User::factory()->create(
            ['account_id' => $account->id, 'email' => $this->faker->safeEmail]
        );

        $company = Company::factory()->create(['account_id' => $account->id]);

        $client = Client::factory()->create(['company_id' => $company->id, 'user_id' => $user->id]);

        ClientContact::factory()->count(2)->create([
            'user_id' => $user->id,
            'client_id' => $client->id,
            'company_id' => $company->id,
        ]);

        Credit::factory()->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'client_id' => $client->id,
            'number' => 'testing-number-01',
            'status_id' => Credit::STATUS_SENT,
            'due_date' => null,
        ]);

        Credit::factory()->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'client_id' => $client->id,
            'number' => 'testing-number-02',
            'due_date' => now(),
            'status_id' => Credit::STATUS_SENT,
        ]);

        Credit::factory()->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'client_id' => $client->id,
            'number' => 'testing-number-03',
            'due_date' => now()->addDays(5),
            'status_id' => Credit::STATUS_SENT,
        ]);

        Credit::factory()->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'client_id' => $client->id,
            'number' => 'testing-number-04',
            'due_date' => '',
            'status_id' => Credit::STATUS_SENT,
        ]);

        $this->actingAs($client->contacts->first(), 'contact');

        Livewire::test(CreditsTable::class, ['company' => $company])
            ->assertSee('testing-number-01')
            ->assertSee('testing-number-02')
            ->assertSee('testing-number-03');
    }

}
