<?php

namespace App\Models;


use App\Models\Scopes\ByTenantScope;
use App\Traits\Tenantable;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'tenant_id'])]
#[Hidden(['password', 'remember_token'])]
//#[ScopedBy(ByTenantScope::class)]
class User extends Authenticatable
{
    use Tenantable;

    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
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

    protected static function booted()
    {
         if (\Illuminate\Support\Facades\Auth::check()) {
            static::addGlobalScope(new ByTenantScope);
        }
    }
}
