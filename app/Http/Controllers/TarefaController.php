<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use App\Models\Subtarefa;
use App\Models\Categoria;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class TarefaController extends Controller
{
    // Método para criar uma nova tarefa
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string|max:255',
        ]);

        try {
            // Criar a tarefa
            $tarefa = Tarefa::create([
                'titulo' => $request->titulo,
                'descricao' => $request->descricao,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Tarefa criada com sucesso!',
                'tarefa' => $tarefa,
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao criar a tarefa: ' . $e->getMessage(),
            ], 400);
        }
    }



    public function index()
    {
        $tarefas = Tarefa::with('subtarefas', 'categorias')->get();

        return response()->json([
            'status' => true,
            'tarefas' => $tarefas,
        ], 200);
    }




    public function update(Request $request, $id)
    {
        // Validação dos campos
        $request->validate([
            'titulo' => 'nullable|string|max:255',
            'descricao' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:pendente,em andamento,concluída',
        ]);

        // Buscar a tarefa pelo ID
        $tarefa = Tarefa::find($id);

        if (!$tarefa) {
            return response()->json([
                'status' => false,
                'message' => 'Tarefa não encontrada.',
            ], 404);
        }

        // Atualizar os campos apenas se forem fornecidos
        $tarefa->update(array_filter($request->only(['titulo', 'descricao', 'status'])));

        // Atualizar subtarefas associadas (se fornecidas)
        if ($request->subtarefas) {
            $tarefa->subtarefas()->delete(); // Deletar subtarefas existentes
            foreach ($request->subtarefas as $subtarefa) {
                $tarefa->subtarefas()->create($subtarefa);
            }
        }

        // Atualizar categorias associadas (se fornecidas)
        if ($request->categorias) {
            $tarefa->categorias()->sync($request->categorias);
        }

        return response()->json([
            'status' => true,
            'message' => 'Tarefa atualizada com sucesso!',
            'tarefa' => $tarefa,
        ], 200);
    }


    // Método para deletar uma tarefa
    public function destroy($id)
    {
        $tarefa = Tarefa::find($id);

        if (!$tarefa) {
            return response()->json([
                'status' => false,
                'message' => 'Tarefa não encontrada.',
            ], 404);
        }

        $tarefa->delete();

        return response()->json([
            'status' => true,
            'message' => 'Tarefa deletada com sucesso!',
        ], 200);
    }
}
