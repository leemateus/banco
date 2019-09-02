<?php

namespace App\Http\Controllers;

use App\Conta;
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
        //
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
        //
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

        if ($processo->transferencia($idContaDebita, $idContaCredita, $valor)) {
            return [
                'status' => true
            ];
        }

        return [
            'status' => false
        ];

    }
}
