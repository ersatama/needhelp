<?php

namespace App\Http\Middleware;

use App\Domain\Contracts\Contract;
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
        $status =   false;
        $ips    =   $this->ipService->ipRepository->get();
        $currentIp  =   explode('.',$request->getClientIp());

        foreach ($ips as &$ip) {
            $parsedIp   =   explode('.',$ip->{Contract::IP});
            if ((int) $parsedIp[0] === (int)$currentIp[0] && (int) $parsedIp[1] === (int)$currentIp[1]) {
                if ($parsedIp[2] === '*') {
                    $status =   true;
                } elseif ((int)$parsedIp[2] === (int)$currentIp[2]) {
                    if ($parsedIp[3] === '*' || ((int)$parsedIp[3] === (int)$currentIp[3])) {
                        $status =   true;
                    }
                }
            }
        }
        if (!$status) {
            return redirect('/logout');
        }
        return $next($request);
    }
}
