@extends('layouts.panel')
@section('title', 'Registrar ingreso')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="animate-in glass-card rounded-2xl p-6 lg:p-8">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-9 h-9 rounded-lg bg-green-500/10 flex items-center justify-center">
                <svg class="w-4.5 h-4.5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            </div>
            <div>
                <h1 class="text-sm font-semibold text-gray-100">Registrar ingreso de inventario</h1>
                <p class="text-xs text-gray-500 mt-0.5">El stock se actualizara automaticamente</p>
            </div>
        </div>

        <form method="POST" action="{{ route('panel.inventario.store-ingreso') }}">
            @csrf
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Repuesto *</label>
                    <select name="repuesto_id" required class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                        <option value="" class="bg-[#1a1a1a]">Seleccionar repuesto</option>
                        @foreach($repuestos as $r)
                            <option value="{{ $r->id }}" class="bg-[#1a1a1a]">{{ $r->nombre }} ({{ $r->codigo }})</option>
                        @endforeach
                    </select>
                    @error('repuesto_id')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Cantidad recibida *</label>
                    <input name="cantidad" type="number" min="1" required class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" placeholder="Ej: 10">
                    @error('cantidad')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
                </div>
                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1.5">Numero de factura</label>
                        <input name="numero_factura" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" placeholder="Opcional">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1.5">Sucursal</label>
                        <select name="sucursal_id" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                            <option value="1" class="bg-[#1a1a1a]">Principal</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Observaciones</label>
                    <textarea name="observaciones" rows="2" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" placeholder="Opcional"></textarea>
                </div>
                <div class="flex items-center gap-3 pt-4 border-t border-white/[0.06]">
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 text-white text-sm font-semibold rounded-full transition shadow-lg shadow-blue-500/25 cursor-pointer">Registrar ingreso</button>
                    <a href="{{ route('panel.inventario.index') }}" class="px-6 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 text-gray-300 text-sm font-medium rounded-full transition">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
