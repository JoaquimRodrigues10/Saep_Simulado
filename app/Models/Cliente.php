<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'nome',
        'cpf',
        'telefone',
        'email',
    ];

    protected $hidden = [
        'cpf',
    ];

    protected function casts(): array
    {
        return [
            'cpf' => 'encrypted',
        ];
    }

    public $timestamps = true;

    public function veiculos()
    {
        return $this->hasMany(Veiculo::class, 'cliente_id');
    }
}
