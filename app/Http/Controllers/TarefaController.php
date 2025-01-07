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
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string|max:255',
            'categorias' => 'nullable|array|max:3',
            'categorias.*' => 'exists:categoria,id',
        ]);

        try {
            $tarefa = Tarefa::create([
                'titulo' => $request->titulo,
                'descricao' => $request->descricao,
            ]);

            if ($request->has('categorias') && count($request->categorias) > 0) {
                $categoriasExistentes = Categoria::whereIn('id', $request->categorias)->pluck('id')->toArray();

                if (count($categoriasExistentes) !== count($request->categorias)) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Algumas categorias não existem.',
                    ], 400);
                }

                $tarefa->categorias()->sync($categoriasExistentes);
            }

            return response()->json([
                'status' => true,
                'message' => 'Tarefa criada com sucesso!',
                'tarefa' => $tarefa,
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao criar a tarefa: ' . $e->getMessage(),
            ], 500);
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
        $request->validate([
            'titulo' => 'nullable|string|max:255',
            'descricao' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:pendente,em andamento,concluída',
        ]);

        $tarefa = Tarefa::find($id);

        if (!$tarefa) {
            return response()->json([
                'status' => false,
                'message' => 'Tarefa não encontrada.',
            ], 404);
        }

        $data = array_filter($request->only(['titulo', 'descricao', 'status']));

        if (isset($data['status']) && $data['status'] === 'concluída') {
            $data['concluido_em'] = now();
        }

        $tarefa->update($data);

        if ($request->subtarefas) {
            $tarefa->subtarefas()->delete();
            foreach ($request->subtarefas as $subtarefa) {
                $tarefa->subtarefas()->create($subtarefa);
            }
        }

        if ($request->categorias) {
            $tarefa->categorias()->sync($request->categorias);
        }

        return response()->json([
            'status' => true,
            'message' => 'Tarefa atualizada com sucesso!',
            'tarefa' => $tarefa,
        ], 200);
    }



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
