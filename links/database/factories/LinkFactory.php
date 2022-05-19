<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Link;
use Faker\Generator as Faker;
$factory="";
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Link>
 */
class LinkFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Link::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     

    public function definition()
    {       
            return [
                'title' => $this->faker->sentence(2),
                'url' =>$this-> faker->url,
                'description' =>$this-> faker->paragraph,
            ];
        // });
          
    }
}
