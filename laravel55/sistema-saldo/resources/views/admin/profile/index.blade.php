@extends('site.layout.app')

@section('title', 'Meu Perfil')

@section('content')
    <h1>Perfil</h1>

    @include('admin.includes.alerts')

    <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">

        {{ csrf_field() }}

        <div class="form-group">
            <label for="name">Nome: </label>
            <input type="text" value="{{ auth()->user()->name }}" name="name" placeholder="Nome" class="form-control">
        </div>
        <div class="form-group">
            <label for="email">E-Mail: </label>
            <input type="email" value="{{ auth()->user()->email }}" name="email" placeholder="E-Mail" class="form-control">
        </div>
        <div class="fform-group">
            <label for="password">Senha: </label>
            <input type="password" name="password" placeholder="Senha" class="form-control">
        </div>
        <div class="form-group">

            @if(auth()->user()->image != null)
                <img src="{{ url('storage/users/'.auth()->user()->image) }}" alt="{{ auth()->user()->name }}" style="max-width: 50px">
            @endif

            <label for="image">Foto: </label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="fform-group">
            <button type="submit" class="btn btn-primary">Atualizar Perfil</button>
        </div>
    </form>
@endsection