<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServidorConfig extends Model
{
    use HasFactory;
    protected $connection = 'db_rh';
    protected $table = 'servidor_config';
    protected $primaryKey = 'id';
}
