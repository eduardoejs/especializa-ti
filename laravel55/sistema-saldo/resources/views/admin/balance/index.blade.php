@extends('adminlte::page')

@section('title', 'Saldo')

@section('content_header')
    <h1>Saldo</h1>

    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="" active>Saldo</a></li>
    </ol>
@stop

@section('content')

    <div class="box">
        <div class="box-header">

            @include('admin.includes.alerts')

            <a href="{{ route('balance.deposit') }}" class="btn btn-primary"><i class="fa fa-cart-plus"></i> Recarregar</a>

            @if($saldo > 0)
                <a href="{{ route('balance.withdraw') }}" class="btn btn-danger"><i class="fa fa-cart-arrow-down"></i> Sacar</a>
                <a href="{{ route('balance.transfer') }}" class="btn btn-info"><i class="fa fa-exchange"></i> Transferir</a>
            @endif
        </div>
        <div class="box-body">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>R$ {{ number_format($saldo, 2, ',', '.') }}</h3>
                    <p>Meu Saldo</p>
                </div>
                <div class="icon">
                    <i class="ion ion-cash"></i>
                </div>
                <a href="{{ route('historic') }}" class="small-box-footer">Histórico de Transações <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

@stop