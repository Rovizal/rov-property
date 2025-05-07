<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        //USA STYLE
        return [
            'beds'      => fake()->numberBetween(1, 7),
            'baths'     => fake()->numberBetween(1, 7),
            'area'      => fake()->numberBetween(30, 400),
            'city'      => fake()->city(),
            'code'      => fake()->postcode(),
            'street'    => fake()->streetName(),
            'street_nr' => fake()->numberBetween(1, 100),
            'price'     => fake()->numberBetween(50_000, 2_000_000)
        ];

        //INDONESIAN STYLE
        // return [
        //     'beds'      => fake('id_ID')->numberBetween(1, 7),
        //     'baths'     => fake('id_ID')->numberBetween(1, 7),
        //     'area'      => fake('id_ID')->numberBetween(30, 400),
        //     'city'      => fake('id_ID')->city(),
        //     'code'      => fake('id_ID')->postcode(),
        //     'street'    => fake('id_ID')->streetName(),
        //     'street_nr' => fake('id_ID')->numberBetween(1, 100),
        //     'price'     => fake('id_ID')->numberBetween(50000000, 20000000000) // harga dalam rupiah
        // ];
    }
}
