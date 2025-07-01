<?php

namespace Database\Factories;

use Doctrine\DBAL\Schema\Index;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Soal>
 */
class SoalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $index;

        return [
            'index' => $index++,
            'pertanyaan' => fake()->paragraph(),
            'type_soal' => 'esai',
            'main_soal_id' => 1
        ];
    }
}
