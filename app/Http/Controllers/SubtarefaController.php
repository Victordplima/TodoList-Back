<?php

namespace App\Http\Controllers;

use App\Models\Subtarefa;
use App\Models\Tarefa;
use Illuminate\Http\Request;
use Exception;

class SubtarefaController extends Controller
{
    public function store(Request $request, $tarefaId)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'status' => 'nullable|string|in:pendente,em andamento,concluída',
        ]);

        $tarefa = Tarefa::find($tarefaId);

        if (!$tarefa) {
            return response()->json([
                'status' => false,
                'message' => 'Tarefa não encontrada.',
            ], 404);
        }

        try {
            $subtarefa = $tarefa->subtarefas()->create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Subtarefa criada com sucesso!',
                'subtarefa' => $subtarefa,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao criar a subtarefa: ' . $e->getMessage(),
            ], 400);
        }
    }

    public function update(Request $request, $subtarefaId)
    {
        $request->validate([
            'titulo' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:pendente,em andamento,concluída',
        ]);

        $subtarefa = Subtarefa::find($subtarefaId);

        if (!$subtarefa) {
            return response()->json([
                'status' => false,
                'message' => 'Subtarefa não encontrada.',
            ], 404);
        }

        try {
            $subtarefa->update(array_filter($request->all()));

            return response()->json([
                'status' => true,
                'message' => 'Subtarefa atualizada com sucesso!',
                'subtarefa' => $subtarefa,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao atualizar a subtarefa: ' . $e->getMessage(),
            ], 400);
        }
    }

    public function destroy($subtarefaId)
    {
        $subtarefa = Subtarefa::find($subtarefaId);

        if (!$subtarefa) {
            return response()->json([
                'status' => false,
                'message' => 'Subtarefa não encontrada.',
            ], 404);
        }

        try {
            $subtarefa->delete();

            return response()->json([
                'status' => true,
                'message' => 'Subtarefa deletada com sucesso!',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao deletar a subtarefa: ' . $e->getMessage(),
            ], 400);
        }
    }
}
