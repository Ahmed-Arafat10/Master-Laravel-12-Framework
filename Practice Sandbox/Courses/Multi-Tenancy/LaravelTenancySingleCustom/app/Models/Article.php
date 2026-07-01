<?php

namespace App\Models;

use App\Models\Scopes\ByTenantScope;
use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy(ByTenantScope::class)]
class Article extends Model
{
    use Tenantable;

    protected $guarded = [];
    protected static function booted(): void
    {
        static::creating(function (Article $article) {
            $article->user_id = auth()->id();
        });
    }
}
