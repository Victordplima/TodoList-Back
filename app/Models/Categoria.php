<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'Categoria';

    protected $fillable = ['nome', 'descricao', 'criado_em', 'cor_em_hexadecimal'];

    public function tarefas()
    {
        return $this->belongsToMany(Tarefa::class, 'TarefaCategoria', 'categoria_id', 'tarefa_id');
    }
}
