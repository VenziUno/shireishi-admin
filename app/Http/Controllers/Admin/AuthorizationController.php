<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repository\AuthorizationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthorizationController extends Controller
{
    protected $authorization;
    function __construct()
    {
        $this->authorization = new AuthorizationRepository;;
    }
    
    function index()
    {
        $data['admin_group'] = $this->authorization->getAdminGroup();
        $content = view('authorization.view', $data);
        return view('main', compact('content'));
    }
    
    function data($id){
        $data['menu'] = $this->authorization->getMenu();
        $data['type'] = $this->authorization->getType();
        $data['admin_group'] = $this->authorization->getAdminGroup();
        $data['authorization'] = $this->authorization->getData($id);
        return view('authorization.data', $data);
    }

    function update(Request $request){
        DB::beginTransaction();
        try {
            $this->authorization->update();
            DB::commit();
        } catch (\Exception $exception) {
            return redirect()->route('authorization_view')->withInput($request->input())->withErrors("Something Wrong");
        }        
    }
}
