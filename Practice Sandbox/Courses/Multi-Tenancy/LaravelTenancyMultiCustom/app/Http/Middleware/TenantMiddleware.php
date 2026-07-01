<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use App\Services\TenantDatabaseService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $subDomain = $request->getHost();
        $isTenant = !Str::contains('multitenancycustom.test', $subDomain);
        if ($isTenant) {
            $tenant = Tenant::query()->where('subdomain', $subDomain)->first();
            if (!$tenant) {
                abort(400, 'Subdomain not found');
            }
            # this condition is useless, but i left it here for the sake of clarity
            if (config('database.connections.tenant.database') !== $tenant->database) {
                (new TenantDatabaseService())->connectToDatabase($tenant);
                (new TenantDatabaseService())->migrateToDB($tenant);
            }
        }
        return $next($request);
    }
}
