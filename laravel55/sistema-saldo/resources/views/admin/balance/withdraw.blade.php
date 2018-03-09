@extends('adminlte::page')

@section('title', 'Sacar da conta')

@section('content_header')
    <h1>Fazer Saque/Retirada</h1>

    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="">Saldo</a></li>
        <li><a href="">Saque</a></li>
    </ol>
@stop

@section('content')

    <div class="box">
        <div class="box-header">

            @include('admin.includes.alerts')

        </div>
        <div class="box-body">
            <form action="{{ route('withdraw.store') }}" method="post">

                {!! csrf_field() !!}

                <div class="form-group">
                    <input type="text" placeholder="Valor do Saque" name="valor" class="form-control">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Sacar/Retirar</button>
                </div>
            </form>
        </div>
    </div>
@stop