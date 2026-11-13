<?php

use App\Models\Curso;
use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\Grupo;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('CP-05: Un grupo con 14 estudiantes no puede abrirse', function () {

    $curso = Curso::create([
        'sigla' => 'IF6100',
        'nombreCurso' => 'Análisis y Diseño de Sistemas',
        'creditos' => 4,
    ]);

    $docente = Docente::create([
        'codEmpleado' => 1001,
        'nombreEmpleado' => 'Ana',
        'apellidosEmpleado' => 'Mora Vargas',
    ]);

    $grupo = Grupo::create([
        'sigla' => 'IF6100',
        'numeroCiclo' => 2,
        'ano' => 2026,
        'numeroGrupo' => 1,
        'abierto' => false, 
    ]);

    $grupo->docentes()->attach($docente->codEmpleado);

    for ($i = 1; $i <= 14; $i++) {
        $estudiante = Estudiante::create([
            'carne' => 'C' . str_pad($i, 5, '0', STR_PAD_LEFT),
            'nombre' => 'Estudiante ' . $i,
            'apellidos' => 'Prueba ' . $i,
            'codEmpleado' => $docente->codEmpleado,
        ]);

        $grupo->estudiantes()->attach($estudiante->carne);
    }

    expect($grupo->puedeAbrirse())->toBeFalse();

    expect(fn () => $grupo->abrir())
        ->toThrow(DomainException::class);

    expect($grupo->fresh()->abierto)->toBeFalse();
});