<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Conta;

class TipoConta extends Model
{
    protected $table = 'contas';

    protected $fillable = ['nome', 'limite'];

    protected $hidden = ['created_at', 'updated_at'];

    public function conta()
    {
        return $this->belongsTo('Conta');
    }
}
