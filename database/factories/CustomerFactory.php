<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CustomerFactory extends Factory
{
    protected $model = \App\Models\Customer::class;

    public function definition()
    {
        return [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'telephone' => $this->faker->unique()->phoneNumber,
            'bvn' => $this->faker->unique()->numerify('##########'),
            'dob' => $this->faker->date(),
            'residential_address' => $this->faker->address,
            'state' => $this->faker->state,
            'bankcode' => $this->faker->numerify('###'),
            'accountnumber' => $this->faker->unique()->numerify('##########'),
            'company_id' => $this->faker->numberBetween(1, 100),
            'email' => $this->faker->unique()->safeEmail,
            'city' => $this->faker->city,
            'country' => $this->faker->country,
        ];
    }
}
