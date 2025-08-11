@extends('template.template')

@section('content')
    @if (Route::is('eleitor.registrar'))
        @include('eleitor.cadastroEleitor')
    @elseif(Route::is('eleitor.login'))
        @include('eleitor.loginEleitor')
    @endif
@endsection
