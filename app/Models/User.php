<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'username', 'email', 'password', 'avatar', 'rol_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ─── RELACIONES ──────────────────────────────────────────────────

    public function rol()
    {
        return $this->belongsTo(Role::class, 'rol_id');
    }

    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'user_id');
    }

    // ─── VERIFICACION DE ROLES ───────────────────────────────────────

    public function tieneRol(string $nombreRol): bool
    {
        return $this->rol?->nombre === $nombreRol;
    }

    public function esAdmin(): bool
    {
        return $this->tieneRol('Administrador');
    }

    public function esCliente(): bool
    {
        return $this->tieneRol('Cliente');
    }
}
