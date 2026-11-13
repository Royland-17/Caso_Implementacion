<?php

use App\Models\Curso;
use App\Models\Estudiante;
use App\Models\Grupo;

test('CP-07 un grupo sin docente no se abre aunque tenga cupo completo', function () {

    $curso = Curso::factory()->create([
        'sigla' => 'IF6100',
        'nombreCurso' => 'Análisis y Diseño de Sistemas',
        'creditos' => 4,
    ]);

    $grupo = Grupo::factory()->create([
        'sigla' => 'IF6100',
        'numeroCiclo' => 2,
        'ano' => 2026,
        'numeroGrupo' => 1,
        'abierto' => false,
    ]);

    $estudiantes = Estudiante::factory()->count(20)->create();
    $grupo->estudiantes()->attach($estudiantes->pluck('carne'));

    expect($grupo->puedeAbrirse())->toBeFalse();

    $this->expectException(\DomainException::class);
    $grupo->abrir();

    expect($grupo->fresh()->abierto)->toBeFalse();
});