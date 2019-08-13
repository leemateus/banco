<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    protected $fillable = ['nome', 'sobrenome'];

    protected $hidden = ['created_at', 'updated_at'];

    protected $table = 'pessoas';
}
