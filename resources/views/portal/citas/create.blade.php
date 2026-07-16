@extends('layouts.portal')
@section('title', 'Reservar cita')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-xl font-bold text-white">Reservar cita</h1>
        <p class="text-sm text-gray-400 mt-1">Completa los pasos para agendar tu servicio</p>
    </div>

    @if(session('error'))
        <div class="mb-6 p-3 bg-red-500/10 border border-red-500/20 rounded-xl text-sm text-red-400">{{ session('error') }}</div>
    @endif

    <div class="glass-card rounded-2xl p-6 lg:p-8">
        <form method="POST" action="{{ route('portal.citas.store') }}">
            @csrf

            <div x-data="{
                paso: 1,
                sucursalId: '',
                servicioId: '',
                tipoSolicitud: 'servicio',
                descripcion: '',
                vehiculoId: '',
                tipoVehiculoId: '',
                fecha: '',
                slots: [],
                slotSeleccionado: '',
                duracion: 30,
                esHoy: false,
                cargandoSlots: false,

                get servicios() {
                    return {{ json_encode($servicios->map(fn($s)=>['id'=>$s->id,'nombre'=>$s->nombre,'tipo_servicio_id'=>$s->tipo_servicio_id,'duracion_estimada_min'=>$s->duracion_estimada_min])) }}
                },

                get serviciosFiltrados() {
                    return this.servicios.filter(s => s.nombre !== 'Diagnostico General');
                },

                buscarSlots() {
                    if (!this.sucursalId || !this.servicioId || !this.fecha) return;
                    this.cargandoSlots = true;
                    this.slots = [];
                    this.slotSeleccionado = '';
                    fetch('{{ route('portal.citas.disponibilidad') }}?sucursal_id=' + this.sucursalId + '&servicio_id=' + this.servicioId + '&fecha=' + this.fecha)
                        .then(r => r.json())
                        .then(data => {
                            this.slots = data.slots || [];
                            this.duracion = data.duracion || 30;
                            this.esHoy = data.es_hoy || false;
                            this.cargandoSlots = false;
                            this.paso = 4;
                        });
                },

                avanzar() {
                    if (this.paso === 1 && this.sucursalId) this.paso = 2;
                    else if (this.paso === 2 && (this.tipoSolicitud === 'diagnostico' || this.servicioId)) this.paso = 3;
                    else if (this.paso === 3 && this.fecha && (this.tipoVehiculoId || this.tipoVehiculoId === 0)) { this.buscarSlots(); }
                },

                retroceder() { if (this.paso > 1) { this.paso--; } },

                get puedeAvanzar() {
                    if (this.paso === 1) return !!this.sucursalId;
                    if (this.paso === 2) return this.tipoSolicitud === 'diagnostico' || !!this.servicioId;
                    if (this.paso === 3) return !!this.fecha && (!!this.tipoVehiculoId || this.tipoVehiculoId === 0);
                    return false;
                }
            }">

                <!-- Step indicator -->
                <div class="flex items-center gap-2 mb-8 text-xs">
                    <template x-for="(label, i) in ['Sucursal','Servicio','Fecha','Horario']" :key="i">
                        <div class="flex items-center gap-2">
                            <div :class="paso >= i+1 ? 'bg-blue-500 text-white' : 'bg-white/5 text-gray-500'" class="w-7 h-7 rounded-full flex items-center justify-center font-semibold" x-text="i+1"></div>
                            <span :class="paso === i+1 ? 'text-white' : 'text-gray-600'" class="hidden sm:inline" x-text="label"></span>
                            <svg x-show="i < 3" class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </template>
                </div>

                @error('sucursal_id')<p class="mb-4 text-sm text-red-400">{{ $message }}</p>@enderror
                @error('servicio_id')<p class="mb-4 text-sm text-red-400">{{ $message }}</p>@enderror
                @error('fecha')<p class="mb-4 text-sm text-red-400">{{ $message }}</p>@enderror
                @error('hora')<p class="mb-4 text-sm text-red-400">{{ $message }}</p>@enderror

                <!-- Step 1: Sucursal -->
                <div x-show="paso === 1">
                    <h3 class="text-sm font-semibold text-gray-100 mb-4">Selecciona la sucursal</h3>
                    <div class="grid sm:grid-cols-2 gap-3">
                        @foreach($sucursales as $s)
                        <button type="button" @click="sucursalId = '{{ $s->id }}'" :class="sucursalId === '{{ $s->id }}' ? 'border-blue-500 bg-blue-500/10' : 'border-white/10 bg-white/5'" class="p-4 rounded-xl border text-left transition hover:border-blue-500/50">
                            <p class="text-sm font-medium text-gray-200">{{ $s->nombre }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $s->direccion }}</p>
                        </button>
                        @endforeach
                    </div>
                    <input type="hidden" name="sucursal_id" :value="sucursalId">
                </div>

                <!-- Step 2: Servicio -->
                <div x-show="paso === 2">
                    <h3 class="text-sm font-semibold text-gray-100 mb-4">Que necesitas?</h3>
                    <div class="flex gap-3 mb-5">
                        <button type="button" @click="tipoSolicitud='servicio'; servicioId=''" :class="tipoSolicitud==='servicio'?'bg-blue-500/20 border-blue-500 text-blue-400':'bg-white/5 border-white/10 text-gray-400'" class="flex-1 p-3 rounded-xl border text-sm font-medium text-center transition">Servicio</button>
                        <button type="button" @click="tipoSolicitud='diagnostico'; servicioId = (servicios.find(s => s.nombre === 'Diagnostico General')?.id || '')" :class="tipoSolicitud==='diagnostico'?'bg-blue-500/20 border-blue-500 text-blue-400':'bg-white/5 border-white/10 text-gray-400'" class="flex-1 p-3 rounded-xl border text-sm font-medium text-center transition">Diagnostico</button>
                    </div>

                    <input type="hidden" name="tipo_solicitud" :value="tipoSolicitud">
                    <input type="hidden" name="servicio_id" :value="servicioId">

                    <template x-if="tipoSolicitud === 'servicio'">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Elige un servicio</label>
                            <div class="grid sm:grid-cols-2 gap-2 max-h-64 overflow-y-auto">
                                <template x-for="s in serviciosFiltrados" :key="s.id">
                                    <button type="button" @click="servicioId = s.id" :class="servicioId == s.id ? 'border-blue-500 bg-blue-500/10' : 'border-white/10 bg-white/5'" class="p-3 rounded-xl border text-left transition hover:border-blue-500/50">
                                        <p class="text-sm text-gray-200" x-text="s.nombre"></p>
                                        <p class="text-xs text-gray-500 mt-0.5" x-text="s.duracion_estimada_min + ' min'"></p>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </template>

                    <template x-if="tipoSolicitud === 'diagnostico'">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Describe el problema</label>
                            <textarea x-model="descripcion" name="descripcion_problema" rows="3" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" placeholder="Ej: Hace un ruido extrano al acelerar..."></textarea>
                        </div>
                    </template>
                </div>

                <!-- Step 3: Fecha + Vehiculo -->
                <div x-show="paso === 3">
                    <div class="grid sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Tipo de vehiculo</label>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach(\App\Models\TipoVehiculo::all() as $tv)
                                <button type="button" @click="tipoVehiculoId = '{{ $tv->id }}'" :class="tipoVehiculoId == '{{ $tv->id }}' ? 'border-blue-500 bg-blue-500/10' : 'border-white/10 bg-white/5'" class="p-3 rounded-xl border text-center transition hover:border-blue-500/50">
                                    <p class="text-sm text-gray-200">{{ $tv->nombre }}</p>
                                </button>
                                @endforeach
                            </div>
                            <input type="hidden" name="tipo_vehiculo_id" :value="tipoVehiculoId">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Vehiculo (opcional)</label>
                            <select name="vehiculo_id" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                                <option value="" class="bg-[#1a1a1a]">Lo registro despues</option>
                                @foreach($vehiculos as $v)
                                <option value="{{ $v->id }}" class="bg-[#1a1a1a]">{{ $v->placa }} — {{ $v->marca?->nombre }} {{ $v->modelo?->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-5">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Que fecha deseas agendar tu cita?</label>
                        <input type="date" name="fecha" x-model="fecha" :min="new Date().toISOString().split('T')[0]" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                    </div>
                </div>

                <!-- Step 4: Slots -->
                <div x-show="paso === 4">
                    <h3 class="text-sm font-semibold text-gray-100 mb-1">Selecciona un horario disponible</h3>
                    <p class="text-xs text-gray-500 mb-4">Selecciona la hora que prefieras. La disponibilidad se calcula segun los mecanicos disponibles en la sucursal. El mecanico sera asignado posteriormente por el administrador.</p>
                    <p class="text-xs text-gray-500 mb-4" x-text="'Duracion estimada: ' + duracion + ' min'"></p>

                    <div x-show="cargandoSlots" class="text-center py-8">
                        <svg class="animate-spin w-8 h-8 mx-auto text-blue-400" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                        <p class="text-sm text-gray-500 mt-3">Consultando disponibilidad...</p>
                    </div>

                    <div x-show="!cargandoSlots && slots.length === 0" class="text-center py-8 text-sm text-gray-500">
                        <template x-if="esHoy">
                            <p>No hay horarios disponibles para hoy. Selecciona otra fecha.</p>
                        </template>
                        <template x-if="!esHoy">
                            <p>No hay horarios disponibles para esta fecha. Selecciona otra fecha.</p>
                        </template>
                    </div>

                    <div x-show="!cargandoSlots && slots.length > 0" class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        <template x-for="slot in slots" :key="slot.hora">
                            <button type="button"
                                @click="slotSeleccionado = slot.disponible ? slot.hora : slotSeleccionado"
                                :disabled="!slot.disponible"
                                :class="slotSeleccionado === slot.hora ? 'ring-2 ring-blue-500 border-blue-500 bg-blue-500/10' : (slot.disponible ? 'border-white/10 bg-white/5 hover:border-blue-500/50' : 'border-white/5 bg-white/[0.02] opacity-40 cursor-not-allowed')"
                                class="p-3 rounded-xl border text-center transition">
                                <p class="text-sm font-semibold" :class="slot.disponible ? 'text-white' : 'text-gray-600'" x-text="slot.hora"></p>
                                <p class="text-xs mt-1" :class="slot.disponible ? 'text-green-400' : 'text-gray-600'" x-text="slot.disponible ? slot.mecanicos_libres + ' mecanicos libres' : 'No disponible'"></p>
                            </button>
                        </template>
                    </div>

                    <input type="hidden" name="hora" :value="slotSeleccionado">
                </div>

                <!-- Navigation -->
                <div class="flex items-center justify-between mt-8 pt-5 border-t border-white/[0.06]">
                    <button type="button" @click="retroceder()" x-show="paso > 1" class="px-5 py-2.5 bg-white/5 border border-white/10 text-gray-300 text-sm font-medium rounded-full transition cursor-pointer">Atras</button>
                    <div></div>
                    <button type="button" @click="paso === 4 ? $el.closest('form').submit() : avanzar()" :disabled="paso === 4 ? !slotSeleccionado : !puedeAvanzar" :class="(paso === 4 ? !slotSeleccionado : !puedeAvanzar) ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-sm font-semibold rounded-full transition shadow-lg shadow-blue-500/25">
                        <span x-text="paso === 4 ? 'Confirmar cita' : 'Continuar'"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
