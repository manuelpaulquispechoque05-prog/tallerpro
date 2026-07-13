@extends('layouts.panel')
@section('title', 'Nuevo cliente')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="animate-in glass-card rounded-2xl p-6 lg:p-8">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-9 h-9 rounded-lg bg-blue-500/10 flex items-center justify-center">
                <svg class="w-4.5 h-4.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            </div>
            <div>
                <h1 class="text-sm font-semibold text-gray-100">Nuevo cliente</h1>
                <p class="text-xs text-gray-500 mt-0.5">Registra un nuevo cliente en el sistema</p>
            </div>
        </div>

        <form method="POST" action="{{ route('panel.clientes.store') }}">
            @csrf
            @include('panel.clientes.form', ['cliente' => null])
        </form>
    </div>
</div>
@endsection
