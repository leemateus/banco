<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TipoConta;
use App\User;

class Conta extends Model
{
    protected $table = 'contas';

    protected $fillable = ['saldo', 'id_tipo_conta'];

    protected $hidden = ['updated_at', 'created_at'];

    public function tipo_conta()
    {
        return $this->belongsTo(TipoConta::class, 'id_tipo_conta', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSaldo($id)
    {
        return $this->where('id', '=', $id)
        ->select('saldo')
        ->get();
    }

    public function validaTransferencia($valor, $id)
    {
        $valida = false;

        $saldo = $this->getSaldo($id);

        if($saldo >= $valor)
        {
            $valida = true;
        }

        return $valida;
    }

    public function transferecia($idContaDebita, $idContaCredita, $valor)
    {
        $validaTransferencia = false; // variavel local - apenas nessa funcao

        $saldoContaDebita = $this->getSaldo($idContaDebita);

        $saldoContaCredita = $this->getSaldo($idContaCredita);

        $aux = $this->validaTransferencia($valor, $idContaDebita); // saber se a conta que sera debitada tem saldo suficiente

        if($aux == true)
        {
            $contaDebita = $this->where('id', '=', $idContaDebita)->first();

            $contaDebita->update([ //objeto da conta q será debitada - operacao débito
                'saldo' => $saldoContaDebita - $valor,
            ]);

            $contaCredita = $this->where('id', '=', $idContaCredita)->first();

            $contaCredita->where('id', '=', $idContaCredita) // operacao crédito
            ->update([
                'saldo' => $saldoContaCredita + $valor
            ]);

            $validaTransferencia = true;
        }

        return $validaTransferencia;
    }
}
