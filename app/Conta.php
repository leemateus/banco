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
        return $this->find($id)->saldo;
        // return self::where('id', '=', $id)
        // ->select('saldo')
        // ->first();

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

    public function transferencia($idContaDebita, $idContaCredita, $valor)
    {

        $saldoContaDebita = $this->getSaldo($idContaDebita);

        try {

            $saldoContaCredita = $this->getSaldo($idContaCredita);

        } catch (\Exception $e) {
            $result = 2; // conta que ira receber nao existe ou esta incorreta

            return $result;
        }

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

            $result = 1; //transferencia com sucesso.
        }

        else
        {
            $result = 3; // conta não tem saldo para transferencia.
        }

        return $result;

    }
}
