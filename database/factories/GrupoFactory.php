<?php

namespace Database\Factories;

use App\Models\Curso;
use App\Models\Grupo;
use Illuminate\Database\Eloquent\Factories\Factory;

class GrupoFactory extends Factory
{
    protected $model = Grupo::class;

    public function definition(): array
    {
        return [
            'sigla' => Curso::factory(),
            'numeroCiclo' => 2,
            'ano' => 2026,
            'numeroGrupo' => $this->faker->unique()->numberBetween(1, 10),
            'abierto' => false,
            'cupo' => 30,
        ];
    }
}