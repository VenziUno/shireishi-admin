<?php
namespace App\Helper;

use App\Models\MenuGroupsModel;
use App\Models\MenusModel;
use App\Models\AuthorizationTypesModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
/**
 * 
 */
class Helper
{
	public static function getGroupMenu()
    {
        $groupmenu = MenuGroupsModel::whereIn('id', [3,4,5,6,7])->get(); //->where('id','>',2)

        return $groupmenu;
    }

    public static function getMenu()
    {
        $tipe = AuthorizationTypesModel::where('name', 'view')->first();

        $menu = MenusModel::join('authorizations', 'authorizations.menus_id', '=', 'menus.id')
            ->where('authorizations.authorization_types_id', $tipe->id)
            ->where('authorizations.admin_groups_id', auth()->user()->admin_groups_id)
            ->orderBy('sort_number', 'asc')->get();
        //        dd($menu->toarray());

        //        $menu = DB::table('tb_menu')->orderBy('urut','asc')->get();
        return $menu;
    }

    public static function getMenunull()
    {
        $menu = DB::table('menus')->orderBy('sort_number', 'asc')->where('menu_groups_id', 1)->get();

        return $menu;
    }
    public static function getMenunull2()
    {
        $tipe = AuthorizationTypesModel::where('name', 'view')->first();

        $menu = MenusModel::join('authorizations', 'authorizations.menus_id', '=', 'menus.id')
            ->where('authorizations.authorization_types_id', $tipe->id)
            ->where('authorizations.admin_groups_id', auth()->user()->admin_groups_id)
            ->where('menus.menu_groups_id', 2)
            ->orderBy('sort_number', 'asc')->get();
        // $menu = DB::table('tb_menu')->orderBy('urut','asc')->where('groupmenu','Nav Bot')->get();

        return $menu;
    }

    public static function changeRouteName()
    {
        $req = \Route::getCurrentRoute()->getName();
        $exp = explode('_', $req);
        $menuName = MenusModel::where('route', $exp[0])->first()->toArray();
        return $menuName;
    }

    public static function staticPath($path, $options = array())
    {
        if ($path == NULL || $path == '') {
            return null;
        }
        if ($options == NULL) {
            $options = array();
        }
        unset($options['s']);
        ksort($options);
        $baseUrl = env('STATIC_PATH');

        $signKey = 'pVtdFYOSKVaPzOOOaoQSwK3LFzQ0A8zC4XGcQhnuOPkMtAQ2MLT2/66/St924ZhuVOe9fy5RiO278UuoXSOBCwK9eD0F17/OkXfmwjLBg6LZlP+2N8KgQzlMIq9VX8RxET8iNnJ2q2Cn+/i6Ju1NCbnPEILJzhZU32vFQh/7k78=';

        $path = ltrim($path, '/');
        $signature = md5($signKey . ':' . $path . '?' . http_build_query($options));
        $options['s'] = $signature;

        $baseUrl = rtrim($baseUrl, '/') . '/' . rtrim($path, '/') . '?' . http_build_query($options);
        return $baseUrl;
    }

    public static function serveImage($path, $options = array())
    {
        if ($path == NULL || $path == '') {
            return null;
        }
        if ($options == NULL) {
            $options = array();
        }
		unset($options['s']);
		$options['b'] = env('AWS_BUCKET');
		ksort($options);
		$baseUrl = env('IMAGE_URL');

        $signKey = 'v-LK4WCdhcfcc%jt*VC2cj%nVpu+xQKvLUA%H86kRVk_4bgG8&CWM#k*b_7MUJpmTc=4GFmKFp7=K%67je-skxC5vz+r#xT?62tT?Aw%FtQ4Y3gvnwHTwqhxUh89wCa_';

        $path = ltrim($path, '/');
        $signature = md5($signKey . ':' . $path . '?' . http_build_query($options));
        $options['s'] = $signature;

        $baseUrl = rtrim($baseUrl, '/') . '/' . rtrim($path, '/') . '?' . http_build_query($options);
        return $baseUrl;
    }
}
