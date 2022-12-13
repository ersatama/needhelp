<?php

namespace App\Http\Middleware;

use App\Domain\Services\IpService;
use Closure;
use Illuminate\Http\Request;

class IpAddressMiddleware
{
    protected IpService $ipService;
    public function __construct(IpService $ipService)
    {
        $this->ipService    =   $ipService;
    }

    public function handle(Request $request, Closure $next)
    {
        if (!$this->ipService->ipRepository->firstByIp($request->getClientIp())) {
            return redirect('/');
        }
        return $next($request);
    }
}
