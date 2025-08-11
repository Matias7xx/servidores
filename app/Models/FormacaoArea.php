<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FormacaoClasse;

class FormacaoArea extends Model
{
    use HasFactory;
    protected $connection = 'db_rh';
    protected $table = 'formacao_area';

    protected $fillable = [
        'id',
        'area',
        'status'
    ];

    public function formacaoClasses()
    {
        return $this->hasMany(FormacaoClasse::class, 'area_id', 'id');
    }
}
