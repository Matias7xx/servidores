<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'servidor_id',
        'name',
        'foto',
        'matricula',
        'password',
        'email',
        'cpf',
        'sexo',
        'telefone',
        'cargo',
        'status',
        'cargo_id',
        'classe_funcional',
        'nivel_funcional',
        'unidade_lotacao_id',
        'unidade_lotacao',
        'unidade_logada_id',
        'unidade_logada',
        'srpc',
        'dspc',
        'nivel',
        'unidade_estrutura_id',
        'unidade_sede',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
