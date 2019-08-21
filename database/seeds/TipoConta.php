<?php

use Illuminate\Database\Seeder;

class TipoConta extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\TipoConta::create([
            'nome' => 'simples',
            'limite' => 5000.00
        ]);
    }
}
