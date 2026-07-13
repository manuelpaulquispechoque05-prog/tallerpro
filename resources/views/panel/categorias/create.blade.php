@extends('layouts.panel')
@section('title', 'Nueva categoria')
@section('content')
<div class="max-w-lg mx-auto">
    <div class="animate-in glass-card rounded-2xl p-6 lg:p-8">
        <h1 class="text-sm font-semibold text-gray-100 mb-6">Nueva categoria</h1>
        <form method="POST" action="{{ route('panel.categorias.store') }}">@csrf @include('panel.categorias.form', ['item' => null])</form>
    </div>
</div>
@endsection
