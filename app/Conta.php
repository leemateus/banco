<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TipoConta;
use App\Pessoa;

class Conta extends Model
{
    protected $table = 'contas';

    protected $fillable = ['saldo', 'id_tipo_conta', 'id_pessoa'];

    protected $hidden = ['updated_at', 'created_at'];

    public function tipo_conta()
    {
        return $this->morphMany(TipoConta::class, 'id_tipo_conta', 'id');
    }

    public function pessoa()
    {
        return $this->hasOne(Pessoa::class, 'id_pessoa', 'id');
    }
}
