<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    use HasFactory;
    protected $connection = 'db_rh';
    protected $primaryKey = 'id_delegacia';
    protected $table = 'delegacia';
}
