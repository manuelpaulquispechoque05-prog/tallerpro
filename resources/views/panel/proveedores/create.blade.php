@extends('layouts.panel')
@section('title', 'Nuevo proveedor')
@section('content')
<div class="max-w-2xl mx-auto">
    <div class="animate-in glass-card rounded-2xl p-6 lg:p-8">
        <h1 class="text-sm font-semibold text-gray-100 mb-6">Nuevo proveedor</h1>
        <form method="POST" action="{{ route('panel.proveedores.store') }}">@csrf @include('panel.proveedores.form', ['item' => null])</form>
    </div>
</div>
@endsection
