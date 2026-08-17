<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * La clave primaria asociada a la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'id_usuario';

    /**
     * 
     
     * @var list<string>
     */
    protected $fillable = [
        'nombre',
        'primer_apellido',
        'segundo_apellido',
        'email',
        'password',
        'rol',
    ];

    /**
     * 
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Obtiene los atributos que deben ser convertidos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Comprueba si el usuario tiene el rol de administrador.
     *
     * @return bool Devuelve verdadero si el rol del usuario es 'administrador'.
     */
    public function esAdministrador(): bool
    {
        return $this->rol === 'administrador';
    }

    /**
     * Comprueba si el usuario tiene el rol de cliente.
     *
     * @return bool Devuelve verdadero si el rol del usuario es 'cliente'.
     */
    public function esCliente(): bool
    {
        return $this->rol === 'cliente';
    }

    /**
     * Accesorio para obtener el nombre del usuario mediante la propiedad 'name'.
     *
     * @return string|null
     */
    public function getNameAttribute(): ?string
    {
        return $this->attributes['nombre'] ?? null;
    }
}