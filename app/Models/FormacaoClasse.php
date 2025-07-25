<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\FormacaoCurso;

class FormacaoClasse extends Model
{
    use HasFactory;
    protected $connection = 'db_rh';
    protected $table = 'formacao_classe';

    protected $fillable = [
        'id',
        'classe',
        'area_id',
        'status'
    ];

    public function formacaoCurso()
    {
        return $this->hasMany(FormacaoCurso::class, 'classe_id', 'id');
    }

    public function formacaoArea()
    {
        return $this->belongsTo(FormacaoArea::class, 'area_id', 'id');
    }
}
