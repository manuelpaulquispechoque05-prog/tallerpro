@extends('layouts.panel')
@section('title', 'Editar categoria')
@section('content')
<div class="max-w-lg mx-auto">
    <div class="animate-in glass-card rounded-2xl p-6 lg:p-8">
        <h1 class="text-sm font-semibold text-gray-100 mb-6">Editar categoria: {{ $item->nombre }}</h1>
        <form method="POST" action="{{ route('panel.categorias.update', $item->id) }}">@csrf @method('PUT') @include('panel.categorias.form', ['item' => $item])</form>
    </div>
</div>
@endsection
