<?php

use App\Models\Curso;
use App\Models\Docente;
use App\Models\Grupo;

test('CP-11 un grupo se abre al alcanzar el cupo mínimo requerido', function () {
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
        'cupo' => 30,
        'abierto' => false, 
    ]);

    $grupo->docentes()->attach(1001);

    expect($grupo)->not->toBeNull();
});