<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Link>
 */
class LinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        use App\Link;
        use Faker\Generator as Faker;

        $factory->define(Link::class, function(Faker $faker)){
            return [
                'title' => substr($faker->sentence(2),0,-1),
                'url' => $faker->url,
                'description' => $faker->paragraph,
            ];
        }
   
    }
}
