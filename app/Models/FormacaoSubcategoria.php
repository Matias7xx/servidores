<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormacaoSubcategoria extends Model
{
    use HasFactory;
    protected $connection = 'db_rh';
    protected $table = 'formacao_subcategoria';

    protected $fillable = [ 
        'nome',
        'formacao_categoria_id',
        'status'
    ];

    public function categoria()
{
    return $this->belongsTo(FormacaoCategoria::class, 'formacao_categoria_id');
}
}
