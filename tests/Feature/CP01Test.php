<?php

use App\Models\Curso;
use App\Models\Grupo;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

mutates(Grupo::class);

test('CP-01: Registrar un grupo con toda su información y su curso', function () {
    $curso = Curso::create([
        'sigla' => 'IF6100',
        'nombreCurso' => 'Análisis y Diseño de Sistemas',
        'creditos' => 4,
    ]);

    $grupo = Grupo::create([
        'sigla' => 'IF6100',
        'numeroCiclo' => 2,
        'ano' => 2026,
        'numeroGrupo' => 1,
        'abierto' => true, 
    ]);

    $grupoRecuperado = Grupo::find($grupo->id);

    expect($grupoRecuperado->numeroCiclo)->toBe(2)
        ->and($grupoRecuperado->ano)->toBe(2026)
        ->and($grupoRecuperado->numeroGrupo)->toBe(1)
        ->and($grupoRecuperado->abierto)->toBeTrue()
        ->and($grupoRecuperado->curso->sigla)->toBe('IF6100')
        ->and($grupoRecuperado->curso->creditos)->toBe(4);
});