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

    public function getSaldo($id)
    {
        return $this->Conta::
        ->where('$id', '=', '$this->id')
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

    public function transferecia($idContaDebita, $idContaCredita, $valor, $contaDebita)
    {
        $validaTransferencia = false;

        $saldoContaDebita = $this->getSaldo($idContaDebita);

        $saldoContaCredita = $this->getSaldo($idContaCredita);

        $aux = $this->validaTransferencia($valor, $idContaDebita);

        if($aux == true)
        {
            $contaDebita->update([ //objeto da conta q será debitada - operacao débito
                'saldo' => $saldoContaDebita - $request->saldo;
            ]);

            Conta::where('id', '=', '$idContaCredita') // operacao crédito
            ->update([
                'saldo' => $saldoContaCredita + $valor
            ]);

            $validaTransferencia = true;
        }

        return $validaTransferencia;
    }
}
