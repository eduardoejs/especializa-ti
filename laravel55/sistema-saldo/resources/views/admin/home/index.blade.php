@extends('adminlte::page')

@section('title', '')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>{{ auth()->user()->name }} - You are logged in!</p>
    @if(auth()->user()->image)
        <img src="{{ url('storage/users/'.auth()->user()->image) }}" alt="{{ auth()->user()->name }}">
    @endif
@stop