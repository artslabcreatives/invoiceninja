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
namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'is_deleted' => false,
            'amount' => $this->faker->numberBetween(1, 10),
            'date' => $this->faker->date(),
            'transaction_reference' => $this->faker->text(10),
            'type_id' => Payment::TYPE_CREDIT_CARD,
            'status_id' => Payment::STATUS_COMPLETED,
        ];
    }
}
