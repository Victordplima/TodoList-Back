<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Tarefa;
use Illuminate\Http\Request;
use Exception;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();

        return response()->json([
            'status' => true,
            'categorias' => $categorias,
        ], 200);
    }



    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cor_em_hexadecimal' => 'nullable|string|size:7', // Validar formato de cor hexadecimal
        ]);

        try {
            $categoria = Categoria::create([
                'nome' => $request->nome,
                'cor_em_hexadecimal' => $request->cor_em_hexadecimal, // Adicionei o campo
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Categoria criada com sucesso!',
                'categoria' => $categoria,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao criar a categoria: ' . $e->getMessage(),
            ], 400);
        }
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'nullable|string|max:255',
            'descricao' => 'nullable|string|max:255',
            'cor_em_hexadecimal' => 'nullable|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/', //regex de hexadecimal
        ]);


        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json([
                'status' => false,
                'message' => 'Categoria não encontrada.',
            ], 404);
        }

        try {
            $categoria->update($request->only(['nome', 'descricao', 'cor_em_hexadecimal']));

            return response()->json([
                'status' => true,
                'message' => 'Categoria atualizada com sucesso!',
                'categoria' => $categoria,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao atualizar a categoria: ' . $e->getMessage(),
            ], 400);
        }
    }




    public function assignToTarefa(Request $request, $tarefaId)
    {
        try {
            // Validação dos dados de entrada
            $request->validate([
                'categorias' => 'required|array', // Verifica se o parâmetro categorias é um array
                'categorias.*' => 'exists:categoria,id', // Verifica se cada id de categoria existe na tabela 'categorias'
            ]);

            // Busca a tarefa pelo ID
            $tarefa = Tarefa::find($tarefaId);

            if (!$tarefa) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tarefa não encontrada.',
                ], 404);
            }

            // Sincroniza as categorias com a tarefa
            $tarefa->categorias()->sync($request->categorias);

            return response()->json([
                'status' => true,
                'message' => 'Categorias atribuídas à tarefa com sucesso!',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao atribuir categorias: ' . $e->getMessage(),
            ], 500);
        }
    }





    public function destroy($id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json([
                'status' => false,
                'message' => 'Categoria não encontrada.',
            ], 404);
        }

        try {
            $categoria->delete();

            return response()->json([
                'status' => true,
                'message' => 'Categoria deletada com sucesso!',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao deletar a categoria: ' . $e->getMessage(),
            ], 400);
        }
    }
}
