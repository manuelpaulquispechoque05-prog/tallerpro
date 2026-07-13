@extends('layouts.panel')
@section('title', 'Nuevo repuesto')
@section('content')
<div class="max-w-2xl mx-auto">
    <div class="animate-in glass-card rounded-2xl p-6 lg:p-8">
        <h1 class="text-sm font-semibold text-gray-100 mb-6">Nuevo repuesto</h1>
        <form method="POST" action="{{ route('panel.repuestos.store') }}">
            @csrf
            @include('panel.repuestos.form', ['repuesto' => null])
        </form>
    </div>
</div>
@endsection
