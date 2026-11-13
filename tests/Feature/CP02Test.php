<?php

use App\Models\Curso;
use App\Models\Grupo;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('CP-02: Un curso tiene varios grupos y se distinguen los abiertos', function () {
    $curso = Curso::create([
        'sigla' => 'IF6100',
        'nombreCurso' => 'Análisis y Diseño de Sistemas',
        'creditos' => 4,
    ]);

    Grupo::create([
        'sigla' => 'IF6100',
        'numeroCiclo' => 2,
        'ano' => 2026,
        'numeroGrupo' => 1,
        'abierto' => true,
    ]);

    Grupo::create([
        'sigla' => 'IF6100',
        'numeroCiclo' => 2,
        'ano' => 2026,
        'numeroGrupo' => 2,
        'abierto' => true,
    ]);

    Grupo::create([
        'sigla' => 'IF6100',
        'numeroCiclo' => 2,
        'ano' => 2026,
        'numeroGrupo' => 3,
        'abierto' => false,
    ]);

    $gruposDelCurso = $curso->grupos;

    $gruposAbiertos = $gruposDelCurso->where('abierto', true);

    expect($gruposDelCurso)->toHaveCount(3)
        ->and($gruposAbiertos)->toHaveCount(2);
});