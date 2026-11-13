<?php

use App\Models\Curso;
use App\Models\Docente;
use App\Models\Grupo;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('CP-04: Un grupo rechaza un tercer docente', function () {

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

    $docente1001 = Docente::create(['codEmpleado' => 1001, 'nombreEmpleado' => 'Ana', 'apellidosEmpleado' => 'Mora Vargas']);
    $docente1002 = Docente::create(['codEmpleado' => 1002, 'nombreEmpleado' => 'Luis', 'apellidosEmpleado' => 'Rojas Solano']);
    $docente1003 = Docente::create(['codEmpleado' => 1003, 'nombreEmpleado' => 'Carla', 'apellidosEmpleado' => 'Jiménez Araya']);

    $grupo->asignarDocente($docente1001->codEmpleado);
    $grupo->asignarDocente($docente1002->codEmpleado);

    expect(fn () => $grupo->asignarDocente($docente1003->codEmpleado))
        ->toThrow(DomainException::class);

    expect($grupo->fresh()->docentes)->toHaveCount(2)
        ->and($grupo->fresh()->docentes->pluck('codEmpleado')->toArray())->not->toContain(1003);
});