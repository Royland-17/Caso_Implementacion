<?php

use App\Models\Curso;
use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\Grupo;
use Illuminate\Database\QueryException;

test('CP-13 un estudiante no se matricula dos veces en el mismo grupo', function () {
    // Precondiciones: Curso, Docente, Grupo, Estudiante C12345 y matrícula inicial en grupo 01
    $curso = Curso::factory()->create([
        'sigla' => 'IF6100',
        'nombreCurso' => 'Análisis y Diseño de Sistemas',
        'creditos' => 4,
    ]);

    $docente = Docente::factory()->create([
        'codEmpleado' => 1001,
        'nombreEmpleado' => 'Ana',
        'apellidosEmpleado' => 'Mora Vargas',
    ]);

    $grupo = Grupo::factory()->create([
        'sigla' => 'IF6100',
        'numeroCiclo' => 2,
        'ano' => 2026,
        'numeroGrupo' => 1,
        'abierto' => false,
        'cupo' => 30,
    ]);

    $estudiante = Estudiante::factory()->create([
        'carne' => 'C12345',
        'nombre' => 'María',
        'apellidos' => 'Solís Quesada',
        'consejero_id' => 1001,
    ]);

    $grupo->estudiantes()->attach($estudiante->carne, ['nota' => null]);

    expect(fn () => $grupo->estudiantes()->attach($estudiante->carne, ['nota' => null]))
        ->toThrow(QueryException::class);

    $conteoMatriculas = \App\Models\EstudianteMatriculado::where('grupo_id', $grupo->id)
        ->where('carne', $estudiante->carne)
        ->count();

    expect($conteoMatriculas)->toBe(1);
});