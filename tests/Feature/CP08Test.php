<?php

use App\Models\Docente;
use App\Models\Estudiante;

test('CP-08 un estudiante queda ligado a su profesor consejero', function () {

    $docente = Docente::factory()->create([
        'codEmpleado' => 1001,
        'nombreEmpleado' => 'Ana',
        'apellidosEmpleado' => 'Mora Vargas',
    ]);

    $estudiante = Estudiante::factory()->create([
        'carne' => 'C12345',
        'nombre' => 'María',
        'apellidos' => 'Solís Quesada',
        'consejero_id' => 1001,
    ]);

    $consejero = $estudiante->consejero;

    $estudiantesAconsejados = $docente->estudiantes;

    expect($consejero->codEmpleado)->toBe(1001);
    expect($estudiantesAconsejados)->toHaveCount(1);
    expect($estudiantesAconsejados->first()->carne)->toBe('C12345');
    expect($estudiante->fresh()->consejero_id)->toBe(1001);
});