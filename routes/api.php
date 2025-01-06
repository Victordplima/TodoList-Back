<?php

use App\Http\Controllers\TarefaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('tarefas')->group(function () {
    Route::post('/', [TarefaController::class, 'store']);        // Criar tarefas
    Route::get('/', [TarefaController::class, 'index']);           // Listar tarefas
    Route::put('/{id}', [TarefaController::class, 'update']);      // Atualizar tarefas
    Route::delete('/{id}', [TarefaController::class, 'destroy']);  // Deletar tarefas
});