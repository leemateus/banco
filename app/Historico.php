<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\conta;

class Historico extends Model
{
    protected $fillable = ['descricao', 'saldoOld', 'saldoNew', 'id_conta'];

    protected $hodden = ['created_at', 'update_at'];

    public function conta(){
        return $this->belongsTo('id_conta', 'id');
    }
}
