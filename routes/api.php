<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TarefaController;
use App\Http\Controllers\SubtarefaController;
use App\Http\Controllers\CategoriaController;

Route::prefix('tarefas')->group(function () {
    Route::post('/', [TarefaController::class, 'store']); // criar tarefas
    Route::get('/', [TarefaController::class, 'index']); // listar tarefas
    Route::put('/{id}', [TarefaController::class, 'update']); // atualizar tarefas
    Route::delete('/{id}', [TarefaController::class, 'destroy']); // deletar tarefas
    Route::post('/{tarefaId}/categorias', [CategoriaController::class, 'assignToTarefa']); // atribuir categoria
});



Route::post('/tarefas/{tarefaId}/subtarefas', [SubtarefaController::class, 'store']); // criar subtarefa
Route::put('/subtarefas/{subtarefaId}', [SubtarefaController::class, 'update']); // editar subtarefa
Route::delete('/subtarefas/{subtarefaId}', [SubtarefaController::class, 'destroy']); // deletar subtarefa



Route::prefix('categorias')->group(function () {
    Route::get('/', [CategoriaController::class, 'index']); // listar categorias
    Route::post('/', [CategoriaController::class, 'store']); // criar categoria
    Route::put('/{id}', [CategoriaController::class, 'update']); // editar categoria
    Route::delete('/{id}', [CategoriaController::class, 'destroy']); // deletar categoria
});
