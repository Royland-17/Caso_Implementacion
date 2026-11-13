<?php

namespace Database\Factories;

use App\Models\Curso;
use Illuminate\Database\Eloquent\Factories\Factory;

class CursoFactory extends Factory
{
    protected $model = Curso::class;

    public function definition(): array
    {
        return [
            'sigla' => 'IF' . $this->faker->unique()->numberBetween(1000, 9999),
            'nombreCurso' => $this->faker->words(3, true),
            'creditos' => 4,
        ];
    }
}