<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 50) as $index) {
            Customer::create([
                'firstname' => $faker->firstName,
                'lastname' => $faker->lastName,
                'telephone' => $faker->unique()->phoneNumber,
                'bvn' => $faker->unique()->numerify('##########'),
                'dob' => $faker->date('Y-m-d', '2003-01-01'),
                'residential_address' => $faker->address,
                'state' => $faker->state,
                'bankcode' => $faker->numerify('###'),
                'accountnumber' => $faker->unique()->bankAccountNumber,
                'company_id' => $faker->numberBetween(1, 100),
                'email' => $faker->unique()->safeEmail,
                'city' => $faker->city,
                'country' => $faker->country,
                'id_card' => $faker->optional()->sha1,
                'voters_card' => $faker->optional()->sha1,
                'drivers_licence' => $faker->optional()->sha1,
            ]);
        }
    }
}
