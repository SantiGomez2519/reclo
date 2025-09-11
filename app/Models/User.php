<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * USER ATTRIBUTES
     * $this->attributes['id'] - int - contains the user primary key (id)
     * $this->attributes['name'] - string - contains the user full name
     * $this->attributes['email'] - string - contains the user email address
     * $this->attributes['password'] - string - contains the user hashed password
     * $this->attributes['role'] - string - contains the user role (admin)
     * $this->attributes['email_verified_at'] - timestamp - contains email verification timestamp
     * $this->attributes['remember_token'] - string - contains remember token for login
     * $this->attributes['created_at'] - timestamp - contains the user creation timestamp
     * $this->attributes['updated_at'] - timestamp - contains the user last update timestamp
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function validateLogin(Request $request): void
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    }

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function setName(string $name): void
    {
        $this->attributes['name'] = $name;
    }

    public function getEmail(): string
    {
        return $this->attributes['email'];
    }

    public function setEmail(string $email): void
    {
        $this->attributes['email'] = $email;
    }

    public function getRole(): string
    {
        return $this->attributes['role'];
    }

    public function setRole(string $role): void
    {
        $this->attributes['role'] = $role;
    }

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    public function getUpdatedAt(): string
    {
        return $this->attributes['updated_at'];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
