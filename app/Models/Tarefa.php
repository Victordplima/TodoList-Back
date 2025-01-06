<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    use HasFactory;

    protected $table = 'Tarefa';

    protected $fillable = ['titulo', 'descricao', 'status', 'criado_em', 'concluido_em'];

    public $timestamps = false;

    public function subtarefas()
    {
        return $this->hasMany(Subtarefa::class, 'tarefa_pai_id');
    }

    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'TarefaCategoria', 'tarefa_id', 'categoria_id');
    }
}
