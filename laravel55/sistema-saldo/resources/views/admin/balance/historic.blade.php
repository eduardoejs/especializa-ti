@extends('adminlte::page')

@section('title', 'Histórico de Transferências')

@section('content_header')
    <h1>Histórico de Movimentações</h1>

    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="" active>Histórico</a></li>
    </ol>
@stop

@section('content')

    <div class="box">
        <div class="box-header">

            <form action="{{ route('historic.search') }}" method="post" class="form form-inline">

                {{ csrf_field() }}

                <input type="text" name="id" class="form-control" placeholder="ID">
                <input type="date" name="date" class="form-control">
                <select name="type" class="form-control">
                    <option value="">Tipo de operação</option>
                    @foreach($types as $key => $type)
                        <option value="{{ $key }}">{{ $type }}</option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-primary">Pesquisar</button>
            </form>

        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Data</th>
                        <th>Valor</th>
                        <th>Tipo de Operação</th>
                        <th>Beneficiário/Origem</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($historics as $historic)
                    <tr>
                        <td>{{ $historic->id }}</td>
                        <td>{{ $historic->date }}</td>
                        <td>R$ {{ number_format($historic->amount, 2, ',', '.') }}</td>
                        <td>{{ $historic->getType($historic->type) }}</td>
                        <td>
                            @if($historic->user_id_transaction)
                                {{-- Abaixo traria um problema de performance no DB pois a cada loop faria a consulta.
                                     "$historic->user()->get()->first()->name"
                                    Então trago os usuarios relacionados com o metodo with no controller
                                 --}}
                                {{ $historic->userDestinatario->name }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>

            @if(isset($dataForm))
                {!! $historics->appends($dataForm)->links() !!}
            @else
                {!! $historics->links() !!}
            @endif

        </div>
    </div>

@stop