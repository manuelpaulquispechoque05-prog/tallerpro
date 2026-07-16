@extends('layouts.panel')
@section('title', 'Editar repuesto')
@section('content')
<div class="max-w-2xl mx-auto">
    <div class="animate-in glass-card rounded-2xl p-6 lg:p-8">
        <h1 class="text-sm font-semibold text-gray-100 mb-6">Editar repuesto: {{ $repuesto->nombre }}</h1>
        <form method="POST" action="{{ route('panel.repuestos.update', $repuesto->id) }}">
            @csrf @method('PUT')
            @include('panel.repuestos.form', ['repuesto' => $repuesto, 'tipoCambio' => $tipoCambio])
        </form>
    </div>
</div>
@endsection
