@extends('adminlte::page')

@section('title', 'Confirmar Transferência de Valores')

@section('content_header')
    <h1>Confirmar Transferência de Valores</h1>

    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="">Saldo</a></li>
        <li><a href="">Transferir</a></li>
        <li><a href="">Confirmação</a></li>
    </ol>
@stop

@section('content')

    <div class="box">
        <div class="box-header">

            @include('admin.includes.alerts')

            <p><strong>Meu saldo atual: </strong>R$ {{ number_format($saldo->amount, 2, ',', '.')  }}</p>
            <p><strong>Destinatário: </strong><i>{{ $destinatario->name }} # < {{ $destinatario->email }} ></i></p>

        </div>
        <div class="box-body">
            <form action="{{ route('transfer.store') }}" method="post">

                {!! csrf_field() !!}

                <input type="hidden" name="destinatario_id" value="{{ $destinatario->id }}">

                <div class="form-group">
                    <input type="text" placeholder="Valor: R$" name="valor" class="form-control">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Confirmar Transferência</button>
                </div>
            </form>
        </div>
    </div>
@stop