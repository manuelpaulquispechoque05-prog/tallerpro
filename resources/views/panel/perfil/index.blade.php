@extends('layouts.panel')
@section('title', 'Mi perfil')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Header -->
    <div class="animate-in glass-card rounded-2xl p-8 lg:p-10 mb-6">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-3xl font-bold shadow-xl shadow-blue-500/20 shrink-0">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div class="text-center sm:text-left flex-1">
                <h1 class="text-2xl font-bold text-white">{{ $user->name }}</h1>
                <p class="text-sm text-gray-400 mt-1">{{ $user->email }}</p>
                <div class="flex flex-wrap gap-2 mt-4 justify-center sm:justify-start">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                        Administrador
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-green-500/10 text-green-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-400"></span>
                        Activo
                    </span>
                </div>
            </div>
            <div class="flex gap-2 shrink-0">
                <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white text-xs font-semibold rounded-full transition-all duration-300 shadow-lg shadow-blue-500/25">
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Editar perfil
                </a>
            </div>
        </div>
    </div>

    <!-- Info cards -->
    <div class="grid sm:grid-cols-2 gap-4 mb-6">
        <div class="animate-in animate-in-d2 glass-card rounded-2xl p-5">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Miembro desde</p>
            <p class="text-base font-semibold text-white">{{ $user->created_at?->isoFormat('D [de] MMMM, YYYY') ?? '—' }}</p>
        </div>
        <div class="animate-in animate-in-d3 glass-card rounded-2xl p-5">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Ultimo acceso</p>
            <p class="text-base font-semibold text-white">{{ $user->ultimo_login_at ? $user->ultimo_login_at->isoFormat('D [de] MMMM, YYYY [a las] HH:mm') : '—' }}</p>
        </div>
    </div>

    <!-- Security -->
    <div class="animate-in animate-in-d4 glass-card rounded-2xl p-5 lg:p-6">
        <h2 class="text-sm font-semibold text-gray-100 mb-4">Seguridad</h2>
        <div class="space-y-3">
            <a href="{{ route('profile.edit') }}#password" class="flex items-center justify-between p-4 rounded-xl bg-white/[0.02] hover:bg-white/[0.04] transition border border-white/[0.04]">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-blue-500/10 flex items-center justify-center">
                        <svg class="w-4.5 h-4.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-200">Cambiar contrasena</p>
                        <p class="text-xs text-gray-500">Actualiza tu contrasena de acceso</p>
                    </div>
                </div>
                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
            <a href="#" class="flex items-center justify-between p-4 rounded-xl bg-white/[0.02] hover:bg-white/[0.04] transition border border-white/[0.04]">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-purple-500/10 flex items-center justify-center">
                        <svg class="w-4.5 h-4.5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-200">Configuracion de cuenta</p>
                        <p class="text-xs text-gray-500">Preferencias y notificaciones</p>
                    </div>
                </div>
                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</div>
@endsection
