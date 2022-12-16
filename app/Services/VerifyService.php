<?php
namespace App\Services;

use App\Models\Lga;
use App\Models\State;

Class VerifyService
{
    public function verifyNIN($nin)
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Faker\Provider\en_US\Person($faker));
        $state = State::find($faker->numberBetween(1, 29));

        $nin_data = [
            'nin' => $nin,
            'first_name' =>  $faker->firstName,
            'last_name' => $faker->lastName,
            'state' =>   $state ->name,
            'lga' => Lga::where(['state_id' => $state->id])->inRandomOrder()->first()->name ?? '',
            'image' => $faker->imageUrl(300, 300, 'people'),
            'gender' => $faker->randomElement(['female' , 'male']),
            'dob' => $faker->date(),
        ];

        return $nin_data;
    }


    public function verifyBVN($nin)
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Faker\Provider\en_US\Person($faker));
        $state = State::find($faker->numberBetween(1, 29));

        $nin_data = [
            'nin' => $nin,
            'first_name' =>  $faker->firstName,
            'last_name' => $faker->lastName,
            'state' =>   $state ->name,
            'lga' => Lga::where(['state_id' => $state->id])->inRandomOrder()->first()->name ?? '',
            'image' => $faker->imageUrl(300, 300, 'people'),
            'gender' => $faker->randomElement(['female' , 'male']),
            'dob' => $faker->date(),
        ];

        return $nin_data;
    }


}
