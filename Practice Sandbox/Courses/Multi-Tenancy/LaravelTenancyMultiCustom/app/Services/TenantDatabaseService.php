<?php

namespace App\Services;

use App\Models\Tenant;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class TenantDatabaseService
{
    public function createDB($databaseName)
    {
        DB::statement("CREATE DATABASE $databaseName");
    }

    public function connectToDatabase(Tenant $tenant)
    {
        $databaseName = $tenant->database;
        Config::set('database.connections.tenant.database', $databaseName);
        DB::purge('mysql');
        DB::reconnect('tenant');
        Config::set('database.default', 'tenant');
    }

    public function migrateToDB(?Tenant $tenant)
    {
        Artisan::call('migrate', [
            '--path' => 'database/migrations/tenant'
        ]);
    }

    public function isUrlInTenant()
    {
        return request()->getHost() !== 'multitenancycustom.test';
    }

}
