@extends('layouts.panel')
@section('title', 'Editar perfil')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="glass-card rounded-2xl p-6 lg:p-8">
        @include('profile.partials.update-profile-information-form')
    </div>
    <div class="glass-card rounded-2xl p-6 lg:p-8">
        @include('profile.partials.update-password-form')
    </div>
    <div class="glass-card rounded-2xl p-6 lg:p-8">
        @include('profile.partials.delete-user-form')
    </div>
</div>
@endsection
