@extends('layouts.panel')
@section('title', 'Especialidades')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h3 class="text-sm font-semibold text-gray-100">Categorias de especialidad</h3>
    <a href="{{ route('panel.especialidades.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-xs font-semibold rounded-full transition shadow-lg shadow-blue-500/25">Nueva especialidad</a>
</div>
@if(session('success'))<div class="mb-4 p-3 bg-green-500/10 border border-green-500/20 rounded-xl text-sm text-green-400">{{ session('success') }}</div>@endif

@if($items->count() > 0)
<div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
    @foreach($items as $i)
    @php
        $gradients = ['from-blue-500/10 to-blue-600/5', 'from-green-500/10 to-green-600/5', 'from-purple-500/10 to-purple-600/5', 'from-amber-500/10 to-amber-600/5', 'from-red-500/10 to-red-600/5', 'from-cyan-500/10 to-cyan-600/5'];
        $g = $gradients[$loop->index % count($gradients)];
        $icons = [
            'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z',
            'M13 10V3L4 14h7v7l9-11h-7z', 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
            'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
            'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
            'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
        ];
        $icon = $icons[$loop->index % count($icons)];
    @endphp
    <div class="glass-card rounded-2xl p-5 hover:shadow-lg transition-all duration-300 group bg-gradient-to-br {{ $g }}">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-xl bg-white/[0.05] flex items-center justify-center group-hover:scale-110 transition-transform"><svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $icon }}"/></svg></div>
            <h4 class="text-sm font-semibold text-gray-100">{{ $i->nombre }}</h4>
        </div>
        <div class="flex items-center justify-between pt-3 border-t border-white/[0.06]">
            <span class="text-xs text-gray-500">0 mecanicos</span>
            <div class="flex gap-1">
                <a href="{{ route('panel.especialidades.edit', $i->id) }}" class="p-1.5 rounded-lg hover:bg-white/10 transition text-gray-500 hover:text-yellow-400"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a>
                <form method="POST" action="{{ route('panel.especialidades.destroy', $i->id) }}" onsubmit="return confirm('Eliminar?')" class="inline">@csrf @method('DELETE')<button type="submit" class="p-1.5 rounded-lg hover:bg-white/10 transition text-gray-500 hover:text-red-400"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="glass-card rounded-2xl p-10 text-center"><p class="text-sm text-gray-500">No hay especialidades</p></div>
@endif
@if($items->hasPages())<div class="mt-6">{{ $items->links() }}</div>@endif
@endsection
