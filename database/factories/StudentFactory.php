<?php

namespace Database\Factories;
use App\Models\Student;
use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name"=> $this->faker->name,
            "order"=> $this->faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]),
            "school_id"=> School::all()->random()->id,
            "status" => $this->faker->randomElement([true,false]),
        ];
    }
}
// use App\Models\Student;
// use App\Models\School;
// use Faker\Generator as Faker;

// $factory->define(Student::class, function (Faker $faker) {
//     return [
//         "name"=> $this->faker->name,
//         "order"=> $this->faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]),
//         "school_id"=> School::all()->random()->id,
//     ];
// });
