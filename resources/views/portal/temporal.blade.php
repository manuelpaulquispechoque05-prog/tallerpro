@extends('layouts.guest')
@section('title', 'Portal del Cliente')

@section('content')
<div class="text-center py-6">
    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-blue-500/20 to-blue-600/20 flex items-center justify-center border border-blue-500/20">
        <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
    </div>
    <h1 class="text-xl font-bold text-white">Portal del Cliente</h1>
    <p class="mt-2 text-sm text-gray-400">Bienvenido, {{ Auth::user()?->name }}.</p>
    <div class="mt-6 p-4 rounded-xl bg-amber-500/10 border border-amber-500/20">
        <p class="text-sm text-amber-400">El portal del cliente esta en construccion.</p>
        <p class="text-xs text-gray-500 mt-1">Proximamente podras reservar citas y consultar tus ordenes desde aqui.</p>
    </div>
    <div class="mt-8">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="px-6 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 text-gray-300 text-sm font-medium rounded-full transition cursor-pointer">Cerrar sesion</button>
        </form>
    </div>
</div>
@endsection
