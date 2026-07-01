<?php

namespace App\Models;

use App\Models\Scopes\ByTenantScope;
use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy(ByTenantScope::class)]
class Comment extends Model
{
    //
    use Tenantable;
    protected $guarded = [];
}
