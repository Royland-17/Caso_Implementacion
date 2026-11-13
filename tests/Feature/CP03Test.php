<?php

use App\Models\Curso;
use App\Models\Docente;
use App\Models\Grupo;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('CP-03: Un grupo acepta dos docentes', function () {

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
        'abierto' => false,
    ]);

    $docente1001 = Docente::create([
        'codEmpleado' => 1001,
        'nombreEmpleado' => 'Ana',
        'apellidosEmpleado' => 'Mora Vargas',
    ]);

    $docente1002 = Docente::create([
        'codEmpleado' => 1002,
        'nombreEmpleado' => 'Luis',
        'apellidosEmpleado' => 'Rojas Solano',
    ]);

    $grupo->docentes()->attach($docente1001->codEmpleado);
    $grupo->docentes()->attach($docente1002->codEmpleado);

    $grupo->load('docentes');
    $docente1001->load('grupos');

    expect($grupo->docentes)->toHaveCount(2)
        ->and($grupo->docentes->pluck('codEmpleado')->toArray())->toContain(1001, 1002)
        ->and($docente1001->grupos->pluck('id')->toArray())->toContain($grupo->id);
});