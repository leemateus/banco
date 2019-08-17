<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Conta;

class Pessoa extends Model
{
    protected $fillable = ['nome', 'sobrenome'];

    protected $hidden = ['created_at', 'updated_at'];

    protected $table = 'pessoas';

    public function conta()
    {
        return $this->hasOne(Conta::class, 'id_pessoa');
    }
}
