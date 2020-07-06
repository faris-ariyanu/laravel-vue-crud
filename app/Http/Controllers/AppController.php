<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AppController extends Controller
{
    public function index(Request $request){
    	if($request->session()->has('user')){
    		$data['menus'] 	= self::getMenu($request->session()->get('user')->id);
    		return view('layouts.app',$data);
    	}else{
			return view('layouts.login');
    	}
    }

    public function getMenu($id)
    {
        $Query  = User::getMenuUser($id,0); 
        $Menus  = [];
        foreach ($Query as $Menu) {
            $Menu['item']   = User::getMenuUser($id,$Menu->id);
            $Menus[]        = $Menu;
        }
        return $Menus;
    }
}
