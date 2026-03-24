<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckModulePermission
{
    public function handle(Request $request, Closure $next, $module)
    {
        $user = auth()->user();

        $hasPermission = DB::table('module_permissions')
            ->join('modules','modules.id','=','module_permissions.module_id')
            ->where('module_permissions.user_id', $user->id)
            ->where('modules.slug', $module)
            ->where('can_view',1)
            ->exists();

        if(!$hasPermission){
            abort(403,'No tienes permiso para acceder a este módulo');
        }

        return $next($request);
    }
}