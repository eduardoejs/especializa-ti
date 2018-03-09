@extends('adminlte::page')

@section('title', 'Transferir Valores')

@section('content_header')
    <h1>Transferência de Valores</h1>

    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="">Saldo</a></li>
        <li><a href="">Transferir</a></li>
    </ol>
@stop

@section('content')

    <div class="box">
        <div class="box-header">

            @include('admin.includes.alerts')

        </div>
        <div class="box-body">
            <form action="{{ route('transfer.confirm') }}" method="get">

                {!! csrf_field() !!}

                <div class="form-group">
                    <input type="text" placeholder="Informe o destinatário [E-mail ou Nome]" name="destinatario" class="form-control">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Pŕoxima etapa</button>
                </div>
            </form>
        </div>
    </div>
@stop