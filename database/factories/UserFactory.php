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

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name'        => $this->faker->name,
            'last_name'         => $this->faker->name,
            'phone'             => $this->faker->phoneNumber,
            'email'             => config('ninja.testvars.username'),
            'email_verified_at' => now(),
            'password'          => bcrypt(config('ninja.testvars.password')), // secret
            'remember_token'    => \Illuminate\Support\Str::random(10),
        ];
    }
}
