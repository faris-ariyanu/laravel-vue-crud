<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Validator;
use App\User;

class AuthController extends Controller
{
    public function do_login(Request $request){
    	try {

            $rule   = ['username' => 'required',
                        'password' => 'required'];
            $validator  = Validator::make($request->all(),$rule);
            if (!$validator->fails()) 
            {

                $Query      = User::join("sys_role","sys_users.role_id","=","sys_role.id")
                                ->where("sys_users.status",1)
                                ->where("sys_role.status",1)
                                ->where("sys_users.username",$request->username)
                                ->select("sys_users.*","sys_role.name as role_name");

                if($Query->count())
                {
                	$Query 	= $Query->first();

                    if(Hash::check($request->password, $Query->password)) 
                    {
                        $data                   = User::find($Query->id);
                        $data->remember_token   = $Query->password;
                        $data->password         = Hash::make($request->password);
                        $data->save();
                        $request->session()->put('user',$data);
                    	return redirect()->route('app');
                    }else{

                        return redirect()->route('app')->with('danger','Username atau password salah');
                    }

                }else{

                   return redirect()->route('app')->with('danger','Username atau password salah');
                }

            }else{

                return redirect()->route('app')->with('danger','Username dan Password harus diisi');
            }

        }catch(\Exception $e){
        	return redirect()->route('app')->with('danger','Oops there is some error with system,please try again letter');
        }
    }

    public function do_logout(Request $request){
    	$request->session()->flush();
    	return redirect()->route('app');
    }

    public function role(Request $request)
    {
        try {

            $Query = User::join("sys_role","sys_users.role_id","=","sys_role.id")
                        ->join("sys_role_menu","sys_role.id","=","sys_role_menu.role_id")
                        ->join("sys_menu","sys_role_menu.menu_id","=","sys_menu.id")
                        ->where("sys_role.status",1)
                        ->where("sys_menu.status",1)
                        ->where("sys_users.status",1)
                        ->where("sys_menu.url",$request->url)
                        ->where("sys_users.remember_token",$_SERVER['HTTP_KEY'])
                        ->select("sys_role_menu.role_menu as role")
                        ->first();
            
            return response()->json(["status"=>true,
                                        "iTotal" => count($Query),
                                        "data"=>(count($Query))?json_decode($Query->role):[]],200);

        }catch(\Exception $e){
            return response()->json(["status"=>false,
                                    "message"=>"Oops there is some error with system,please try again letter",
                                    "data"=>[]],200);
        }                
    }
}
