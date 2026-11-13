<?php

use App\Models\Curso;
use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\Grupo;
use App\Models\EstudianteMatriculado;

test('CP-12 rechaza notas menores que 0 o mayores que 10', function ($valorInvalido) {

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

    expect(fn () => $grupo->registrarNota($estudiante, $valorInvalido))
        ->toThrow(InvalidArgumentException::class);

    // Cambiado 'estudiante_id' por 'carne'
    $matricula = EstudianteMatriculado::where('grupo_id', $grupo->id)
        ->where('carne', $estudiante->carne) 
        ->first();

    expect($matricula->nota)->toBeNull();

})->with([-1, 10.5]);