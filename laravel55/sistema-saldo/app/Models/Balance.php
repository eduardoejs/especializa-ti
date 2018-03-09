<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Balance extends Model
{
    // nao vou usar o recurso de timestamps. na migration correspondente eu excluo o comando
    public $timestamps = false;

    public function deposit(float $valor) : Array
    {
        DB::beginTransaction();

        $totalBefore = $this->amount ? $this->amount : 0;

        $this->amount += number_format($valor, 2, '.', '');
        $deposit = $this->save();

        $historic = auth()->user()->historics()->create([
            'type' => 'I',
            'amount' => $valor,
            'total_before' => $totalBefore,
            'total_after' => $this->amount,
            'date' => date('Ymd'),
        ]);

        if($deposit && $historic)
        {
            DB::commit();

            return [
                'success' => true,
                'message' => 'Sucesso ao recarregar'
            ];
        }else{

            DB::rollback();

            return [
                'success' => false,
                'message' => 'Falha ao recarregar'
            ];
        }
    }

    public function withdraw(float $valor) : Array
    {
        if($this->amount < $valor){
            return [
                'success' => false,
                'message' => 'Saldo insuficiente!',
            ];
        }

        DB::beginTransaction();

        $totalBefore = $this->amount ? $this->amount : 0;

        $this->amount -= number_format($valor, 2, '.', '');
        $withdraw = $this->save();

        $historic = auth()->user()->historics()->create([
            'type' => 'O',
            'amount' => $valor,
            'total_before' => $totalBefore,
            'total_after' => $this->amount,
            'date' => date('Ymd'),
        ]);

        if($withdraw && $historic)
        {
            DB::commit();

            return [
                'success' => true,
                'message' => 'Sucesso ao sacar'
            ];
        }else{

            DB::rollback();

            return [
                'success' => false,
                'message' => 'Falha ao sacar'
            ];
        }
    }

    public function transfer(float $valor, User $destinatario) : Array
    {
        if($this->amount < $valor)
            return [
                'success' => false,
                'message' => 'Saldo insuficiente!'
            ];


        DB::beginTransaction();

        /*
         * Atualiza o proprio saldo do usuario logado
         * */
        $totalBefore = $this->amount ? $this->amount : 0;
        $this->amount -= number_format($valor, 2, '.', '');
        $transfer = $this->save();

        $historic = auth()->user()->historics()->create([
            'type' => 'T',
            'amount' => $valor,
            'total_before' => $totalBefore,
            'total_after' => $this->amount,
            'date' => date('Ymd'),
            'user_id_transaction' => $destinatario->id,
        ]);

        /*
         * Atualiza o saldo do destinatario
         * */
        $saldoDestino = $destinatario->balance()->firstOrCreate([]);//caso nao tenha saldo ainda uso firstOrCreate
        $totalBeforeDestino = $saldoDestino->amount ? $saldoDestino->amount : 0;
        $saldoDestino->amount += number_format($valor, 2, '.', '');
        $transferDestino = $saldoDestino->save();

        $historicDestino = $destinatario->historics()->create([
            'type' => 'I',
            'amount' => $valor,
            'total_before' => $totalBeforeDestino,
            'total_after' => $saldoDestino->amount,
            'date' => date('Ymd'),
            'user_id_transaction' => auth()->user()->id,
        ]);

        if($transfer && $historic && $transferDestino && $historicDestino)
        {
            DB::commit();

            return [
                'success' => true,
                'message' => 'Sucesso ao transferir valores'
            ];
        }else{

            DB::rollback();

            return [
                'success' => false,
                'message' => 'Falha ao transferir'
            ];
        }
    }
}
