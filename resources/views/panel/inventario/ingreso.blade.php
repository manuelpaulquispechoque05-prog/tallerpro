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

        <form method="POST" action="{{ route('panel.inventario.store-ingreso') }}" x-data="{
            moneda: 'Bs',
            precio: '',
            repuestos: {{ json_encode($repuestos->map(fn($r) => [
                'id' => $r->id,
                'nombre' => $r->nombre,
                'codigo' => $r->codigo,
                'precio_compra_original' => (float)($r->precio_compra_original ?? $r->precio_compra ?? 0),
                'moneda_compra' => $r->moneda_compra ?? 'Bs',
            ])) }},

            autocompletar(e) {
                const id = e.target.value;
                const r = this.repuestos.find(r => r.id == id);
                if (r && r.precio_compra_original > 0) {
                    this.precio = r.precio_compra_original;
                    this.moneda = r.moneda_compra;
                }
            }
        }">
            @csrf
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Repuesto *</label>
                    <select name="repuesto_id" required @change="autocompletar" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50">
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

                <!-- Precio y moneda -->
                <div class="grid sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1.5">Precio unitario</label>
                        <input name="precio_unitario" type="number" step="0.01" min="0" x-model="precio"
                               class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50"
                               placeholder="0.00">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1.5">Moneda</label>
                        <select name="moneda" x-model="moneda" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                            <option value="Bs" class="bg-[#1a1a1a]">Bolivianos (Bs)</option>
                            <option value="USD" class="bg-[#1a1a1a]">Dolares (USD)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1.5">Equivalente en Bs</label>
                        <div class="px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-sm text-gray-400">
                            <template x-if="moneda === 'Bs'">
                                <span x-text="precio ? 'Bs ' + parseFloat(precio).toFixed(2) : '—'"></span>
                            </template>
                            <template x-if="moneda === 'USD'">
                                <span x-text="precio ? 'Bs ' + (parseFloat(precio) * {{ $tipoCambio }}).toFixed(2) : '—'"></span>
                            </template>
                            <template x-if="!precio || precio <= 0">
                                <span>Sin precio</span>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1.5">Numero de factura</label>
                        <input name="numero_factura" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" placeholder="Opcional">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1.5">Sucursal</label>
                    <select name="sucursal_id" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                        @foreach($sucursales as $s)
                            <option value="{{ $s->id }}" class="bg-[#1a1a1a]" {{ $loop->first ? 'selected' : '' }}>{{ $s->nombre }}</option>
                        @endforeach
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
