<?php

namespace App\Http\Controllers;

use App\Conta;
use App\Pessoa;
use App\Historico;
use App\Http\Requests\Conta\ContaTranferencia;
use App\Http\Requests\Conta\ContaDeposito;
use Illuminate\Http\Request;

class ContaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Response()->json('ok');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Conta  $conta
     * @return \Illuminate\Http\Response
     */
    public function show(Conta $conta)
    {

        return Response()->json($conta);
        // return 'ok';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Conta  $conta
     * @return \Illuminate\Http\Response
     */
    public function edit(Conta $conta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Conta  $conta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conta $conta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Conta  $conta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conta $conta)
    {
        //
    }

    public function transferencia(Request $request)
    {
        $idContaCredita = $request->idContaCredita;
        $valor = $request->valor;
        $idUserContaDebita = auth()->user()->id; // usuario que faz a transferencia..

        $idContaDebita = Conta::where('user_id', '=', $idUserContaDebita)// id da conta do usuario logado
        ->first()->id;

        $processo = new Conta();

        $aux = $processo->transferencia($idContaDebita, $idContaCredita, $valor);

        if($aux == 1)
        {
            return [
                'status' => 'transferencia realizada com sucesso'
            ];
        }

        if($aux == 2)
        {
            return [
                'status' => 'conta para transferir não existe ou está incorreta'
            ];
        }

        if($aux == 3)
        {
            return [
                'status' => 'sua conta não tem saldo para transferencia'
            ];
        }

    }

    public function minhaconta()
    {
        $user = auth()->user()->id; // id do usuário logado

        $minhaconta = Conta::where('user_id', '=', $user)->first();

        return Response()->json($minhaconta);
    }

    public function deposito(ContaDeposito $request)
    {
        $user = auth()->user()->id; // id do usuário logado

        $contaCreditada = Conta::where('user_id', '=', $user)->first();

        $saldo = $contaCreditada->saldo; // saldo da conta que irá receber o depósito

        $contaCreditada->update([
            'saldo' => $request->valorCreditado + $saldo,
        ]);

        $novoSaldo = $contaCreditada->saldo;

        $historico = Historico::create([
            'id_conta' => $contaCreditada->id,
            'saldoNew' => $novoSaldo,
            'saldoOld' => $saldo,
            'descricao' => "deposito",
        ]);

        return [ 'status' => 'Deposito realizado com sucesso', 'Novo saldo' => $novoSaldo, 'saldo anterior' => $saldo, 'valor depositado' => $request->valorCreditado];
    }

    public function extrato(Request $request)
    {
        $user = auth()->user()->id; // id do usuário logado

        $conta = Conta::where('user_id', '=', $user)->first(); // conta do cliente

        $extrato = Historico::whereYear('created_at', '=', $request->ano)
        ->whereMonth('created_at', '=', $request->mes)
        ->where('id_conta', '=', $conta->id)
        ->get();

        // dd($request->mes);

        return Response()->json($extrato);
    }

}
