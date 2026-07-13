@extends('layouts.panel')
@section('title', 'Editar vehiculo')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="animate-in glass-card rounded-2xl p-6 lg:p-8">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-9 h-9 rounded-lg bg-yellow-500/10 flex items-center justify-center">
                <svg class="w-4.5 h-4.5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </div>
            <div>
                <h1 class="text-sm font-semibold text-gray-100">Editar vehiculo</h1>
                <p class="text-xs text-gray-500 mt-0.5">{{ $vehiculo->placa }} — #{{ $vehiculo->id }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('panel.vehiculos.update', $vehiculo->id) }}">
            @csrf @method('PUT')
            @include('panel.vehiculos.form', ['vehiculo' => $vehiculo])
        </form>
    </div>
</div>
@endsection
