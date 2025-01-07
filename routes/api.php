<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TarefaController;
use App\Http\Controllers\SubtarefaController;

Route::prefix('tarefas')->group(function () {
    Route::post('/', [TarefaController::class, 'store']); // criar tarefas
    Route::get('/', [TarefaController::class, 'index']); // listar tarefas
    Route::put('/{id}', [TarefaController::class, 'update']); // atualizar tarefas
    Route::delete('/{id}', [TarefaController::class, 'destroy']); // deletar tarefas
});


Route::post('/tarefas/{tarefaId}/subtarefas', [SubtarefaController::class, 'store']); // criar subtarefa
Route::put('/subtarefas/{subtarefaId}', [SubtarefaController::class, 'update']); // editar subtarefa
Route::delete('/subtarefas/{subtarefaId}', [SubtarefaController::class, 'destroy']); // deletar subtarefa
