<?php

namespace App\Traits;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait Tenantable
{

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    #[Scope]
    public function ForTenant(Builder $query, $tenant_id)
    {
        return $query->where('tenant_id', $tenant_id);
    }

    protected static function bootTenantable(): void
    {
        static::creating(function (Model $model) {
            $model->tenant_id = auth()->user()->tenant_id;
        });
    }
}
