<?php

namespace Sroutier\LESKModules\Middleware;

use Sroutier\LESKModules\Modules;
use Closure;

class IdentifyModule
{
    /**
     * @var Sroutier\LESKModules
     */
    protected $module;

    /**
     * Create a new IdentifyModule instance.
     *
     * @param Sroutier\LESKModules $module
     */
    public function __construct(Modules $module)
    {
        $this->module = $module;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $slug)
    {
        $request->session()->put('module', $this->module->where('slug', $slug)->first());

        return $next($request);
    }
}
