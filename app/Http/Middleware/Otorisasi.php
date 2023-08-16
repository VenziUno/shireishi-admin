<?php

namespace App\Http\Middleware;

use App\Models\AuthorizationsModel;
use App\Models\AuthorizationTypesModel;
use App\Models\MenusModel;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class Otorisasi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        $req = $request->route()->getName();
        $exp = explode('_', $req);
        $menu = MenusModel::where('route', $exp[0])->first();
        $tipe = AuthorizationTypesModel::where('name', $exp[1])->first();
        $otorisasi = AuthorizationsModel::where('admin_groups_id', Auth::user()->admin_groups_id)->with(['AdminGroup', 'Menu', 'AuthType'])
            ->where('menus_id', $menu['id'])
            ->where('authorization_types_id', $tipe['id'])
            ->first();

        if($otorisasi === null) {
            if($request->ajax() == true){
                return response()->json('You need authorization from the Master',401);
            }
           abort(403, "You don't have access");  
        }
        return $next($request);
     }
}
