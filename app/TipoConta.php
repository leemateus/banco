<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoConta extends Model
{
    protected $table = 'contas';

    protected $fillable = ['nome', 'limite'];

    protected $hodden = ['created_at', 'updated_at'];
}
