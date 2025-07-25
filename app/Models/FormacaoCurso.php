<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormacaoCurso extends Model
{
    use HasFactory;
    protected $connection = 'db_rh';
    protected $table = 'formacao_curso';

    protected $fillable = [
        'id',
        'curso',
        'classe_id',
        'area_id',
        'status'
    ];

    public function formacaoClasse()
    {
        return $this->belongsTo(FormacaoClasse::class, 'classe_id', 'id');
    }

    public function subcategoria()
{
    return $this->belongsTo(FormacaoSubcategoria::class, 'sub_categoria_id');
}
}
