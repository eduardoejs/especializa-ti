<?php

namespace App\Http\Controllers\Admin;

use App\Models\Balance;
use App\Models\Historic;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\MoneyValidationFormRequest;
use App\Http\Controllers\Controller;

class BalanceController extends Controller
{
    private $paginate = 12;

    public function index()
    {
        $balance = auth()->user()->balance;
        $amount = $balance ? $balance->amount : 0;

        return view('admin.balance.index', ['saldo' => $amount]);
    }

    public function deposit()
    {
        return view('admin.balance.deposit');
    }

    public function depositStore(MoneyValidationFormRequest $request)
    {
        //resgato o saldo do usuario logado criando uma instancia do objeto Balance
        $balance = auth()->user()->balance()->firstOrCreate([]);
        $response = $balance->deposit($request->valor);//passo ao model Balance o valor para ser incrementado

        if($response['success']){
            return redirect()->route('balance')->with('success', $response['message']);
        }

        return redirect()->back()->with('error', $response['message']);
    }

    public function withdraw()
    {
        return view('admin.balance.withdraw');
    }

    public function withdrawStore(MoneyValidationFormRequest $request)
    {
        //resgato o saldo do usuario logado criando uma instancia do objeto Balance
        $balance = auth()->user()->balance()->firstOrCreate([]);
        $response = $balance->withdraw($request->valor);//passo ao model Balance o valor para ser decrementado

        if($response['success']){
            return redirect()->route('balance')->with('success', $response['message']);
        }

        return redirect()->back()->with('error', $response['message']);
    }

    public function transfer()
    {
        return view('admin.balance.transfer');
    }

    public function transferConfirm(Request $request, User $user)
    {
        $destinatario = $user->getDestinatario($request->destinatario);

        if(!$destinatario) {
            return redirect()->back()->with('error', 'Destinatário não encontrado!');
        }

        if($destinatario->id == auth()->user()->id){
            return redirect()->back()->with('error', 'Você não pode transferir valor pra si mesmo!');
        }

        $saldo = auth()->user()->balance ? auth()->user()->balance : 0;

        return view('admin.balance.confirm-transfer', ['destinatario' => $destinatario, 'saldo' => $saldo]);
    }

    public function transferStore(MoneyValidationFormRequest $request, User $user)
    {
        if(!$destinatario = $user->find($request->destinatario_id)){
            return redirect()->route('balance.transfer')->with('error', 'Destinatário não encontrado!');
        }

        $saldo = auth()->user()->balance()->firstOrCreate([]);
        $response = $saldo->transfer($request->valor, $destinatario);

        if($response['success']){
            return redirect()->route('balance')->with('success', $response['message']);
        }

        return redirect()->back()->with('error', $response['message']);
    }

    public function historic(Historic $historic)
    {
        //$historics = auth()->user()->historics;
        $historics = auth()->user()->historics()->with(['userDestinatario'])->orderBy('created_at', 'desc')->paginate($this->paginate);

        $types = $historic->getType();//dependence injection

        return view('admin.balance.historic', ['historics' => $historics, 'types' => $types]);
    }

    public function historicSearch(Request $request, Historic $historic)
    {
        $data = $request->except(['_token']);
        $historics = $historic->search($data, $this->paginate);
        $types = $historic->getType();

        return view('admin.balance.historic', ['historics' => $historics, 'types' => $types, 'dataForm' => $data]);
    }
}
