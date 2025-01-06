<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtarefa extends Model
{
    use HasFactory;

    protected $table = 'Subtarefa';

    protected $fillable = ['titulo', 'descricao', 'status', 'tarefa_pai_id', 'criado_em', 'concluido_em'];

    public function tarefa()
    {
        return $this->belongsTo(Tarefa::class, 'tarefa_pai_id');
    }
}
