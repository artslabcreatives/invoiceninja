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
namespace Tests\Feature\Payments;


use App\Models\Payment;
use App\Utils\Traits\MakesHash;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutEvents;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Validation\ValidationException;
use Tests\MockAccountData;
use Tests\MockUnitData;
use Tests\TestCase;

/**
 * @test
 */
class UnappliedPaymentDeleteTest extends TestCase
{
    use MakesHash;
    use DatabaseTransactions;
    use MockUnitData;
    use WithoutEvents;

    public function setUp() :void
    {
        parent::setUp();

        $this->faker = \Faker\Factory::create();

        $this->makeTestData();
        $this->withoutExceptionHandling();

        $this->withoutMiddleware(
            ThrottleRequests::class
        );
    }

   public function testUnappliedPaymentDelete()
   {

        $data = [
            'amount' => 1000,
            'client_id' => $this->client->hashed_id,
            'invoices' => [
            ],
            'date' => '2020/12/12',

        ];

        $response = null;

        try {
            $response = $this->withHeaders([
                'X-API-SECRET' => config('ninja.api_secret'),
                'X-API-TOKEN' => $this->token,
            ])->post('/api/v1/payments', $data);
        } catch (ValidationException $e) {
            $message = json_decode($e->validator->getMessageBag(), 1);
            $this->assertNotNull($message);
        }

        if ($response){
            $arr = $response->json();
            $response->assertStatus(200);
            
        
            $payment_id = $arr['data']['id'];
            $payment = Payment::with('client')->find($this->decodePrimaryKey($payment_id));

            $this->assertEquals(1000, $payment->amount);
            $this->assertEquals(1000, $payment->client->paid_to_date);

            try {
                $response = $this->withHeaders([
                    'X-API-SECRET' => config('ninja.api_secret'),
                    'X-API-TOKEN' => $this->token,
                ])->delete('/api/v1/payments/'. $payment_id);
            } catch (ValidationException $e) {
                $message = json_decode($e->validator->getMessageBag(), 1);
                $this->assertNotNull($message);
            }

            $response->assertStatus(200);

            $this->assertEquals(0, $this->client->fresh()->paid_to_date);

        }



   }

}