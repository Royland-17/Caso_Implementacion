<?php

use App\Models\Curso;
use App\Models\Docente;
use App\Models\Grupo;

test('CP-10 un grupo se crea asociado a un curso y un docente con cupo válido', function () {

    $curso = Curso::factory()->create([
        'sigla' => 'IF1300',
        'nombreCurso' => 'Arquitectura de Computadores',
    ]);

    $docente = Docente::factory()->create([
        'codEmpleado' => 1001,
        'nombreEmpleado' => 'Ana',
        'apellidosEmpleado' => 'Mora Vargas',
    ]);

    $grupo = Grupo::factory()->create([
        'numeroGrupo' => 1,
        'sigla' => 'IF1300',
        'numeroCiclo' => 2,
        'ano' => 2026,
        'abierto' => false,
    ]);

    $grupo->docentes()->attach($docente->codEmpleado); 

    expect($grupo)->not->toBeNull();
    expect($grupo->sigla)->toBe('IF1300');

    expect($curso->fresh()->grupos)->toHaveCount(1);
    expect($curso->fresh()->grupos->first()->id)->toBe($grupo->id);
});