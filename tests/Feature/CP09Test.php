<?php

use App\Models\Docente;
use App\Models\Estudiante;

test('CP-09 un estudiante puede cambiar de profesor consejero', function () {

    $docente1 = Docente::factory()->create([
        'codEmpleado' => 1001,
        'nombreEmpleado' => 'Ana',
        'apellidosEmpleado' => 'Mora Vargas',
    ]);

    $docente2 = Docente::factory()->create([
        'codEmpleado' => 1002,
        'nombreEmpleado' => 'Carlos',
        'apellidosEmpleado' => 'Jiménez Rojas',
    ]);

    $estudiante = Estudiante::factory()->create([
        'carne' => 'C12345',
        'nombre' => 'María',
        'apellidos' => 'Solís Quesada',
        'consejero_id' => 1001,
    ]);

    $estudiante->update(['consejero_id' => 1002]);

    expect($estudiante->fresh()->consejero_id)->toBe(1002);
    expect($estudiante->fresh()->consejero->codEmpleado)->toBe(1002);
    expect($docente1->fresh()->estudiantes)->toHaveCount(0);
    expect($docente2->fresh()->estudiantes)->toHaveCount(1);
    expect($docente2->fresh()->estudiantes->first()->carne)->toBe('C12345');
});