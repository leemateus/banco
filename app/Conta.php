<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TipoConta;

class Conta extends Model
{
    protected $table = 'contas';

    protected $fillable = ['saldo', 'id_tipo_conta', 'id_pessoa'];

    public function tipo_conta()
    {
        return $this->morphMany('TipoConta');
    }

    public function pessoa()
    {
        return $this->hasOne('TipoConta');
    }
}
