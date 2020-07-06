<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\User;
use Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * query to get data
     *
     * @return void
     */
    public function index(Request $request)
    {
        try {
            
            $Query      = User::with('role')
                            ->with('status')
                            ->select("sys_users.*");

            if($request->has('id'))
            {
                $Query  = $Query->where("sys_users.id",$request->id)
                                ->first();
                $iTotal     = count($Query);

            }else{

                if($request->has('search')){
                    $Query    = $Query->where(function ($query) use($request) {
                                    $query->orWhereRaw("lower(sys_users.username) like '%".$request->search."%'")
                                    ->orWhereRaw("lower(sys_users.fullname) like '%".$request->search."%'");
                                });
                }
                
                $iTotal     = count($Query->get());
                
                if($request->has('status')){
                    $Query    = $Query->where("status",$request->status);
                }

                if($request->has('orderby') && $request->has('sort')){
                    $Query    = $Query->orderby($request->orderby,$request->sort);
                }

                if($request->has('limit') && $request->has('offset')){
                    $Query    = $Query->skip($request->offset)
                                    ->take($request->limit)
                                    ->get();
                }else{
                    $Query    = $Query->get();
                }
            }

            return response()->json(["status"=>true,
                                        "message"=>"Berhasil Mengambil Data",
                                        "iTotal" => $iTotal,
                                        "data"=>$Query],200);
        }catch(\Exception $e){
            return response()->json(["status"=>false,
                                    "message"=>"Oops there is some error with system,please try again letter",
                                    "data"=>[]],200);
        }
    }

    /**
     * set array rule
     *
     * @return void
     */
    public function rule()
    {
        $rule       = ['role' => 'required|max:9',
                        'username' => 'required|max:125',
                        'fullname' => 'required|max:125',
                        'email' => 'required|max:125',
                        'status' => 'required'
                    ];

        return $rule;
    }

    /**
     * store data to database
     *
     * @return void
     */
    public function store(Request $request)
    {
        try {

            $rule = self::rule();
            $rule['password'] = 'required|max:125';
            $validator  = Validator::make($request->all(), $rule);
            if (!$validator->fails()) 
            {   
                $Qcheck             = User::where("username",$request->username)->count();
                if(!$Qcheck)
                {
                    $data               = new User;
                    $data->role_id      = $request->role;
                    $data->username     = $request->username;
                    $data->password     = Hash::make($request->password);
                    $data->fullname     = $request->fullname;
                    $data->email        = $request->email;
                    $data->status       = $request->status;
                    $data->save();
                        
                    return response()->json(["status"=>true,
                                            "message"=>"Berhasil menyimpan data",
                                            "data"=>$data],200);  
                }else{

                    return response()->json(["status"=>false,
                                            "message"=>"Username tidak tersedia.",
                                            "data"=>[]],200);  
                } 

            }else{
                return response()->json(["status"=>false,
                                        "message"=>$validator->messages(),
                                        "data"=>[]],200);
            }

        }catch(\Exception $e){
           return response()->json(["status"=>false,
                                    "message"=>"Oops there is some error with system,please try again letter",
                                    "data"=>[]],200);
        }
    }

    /**
     * update data and save again
     *
     * @return void
     */
    public function update(Request $request)
    {
        try {

            $validator  = Validator::make($request->all(), self::rule());
            if (!$validator->fails()) 
            {   
                $data               = User::find($request->id);
                if(count($data))
                {
                    if($request->username != $request->old_username)
                    {
                        $Qcheck             = User::where("username",$request->username)->count(); // check username
                        if($Qcheck)
                        {
                            return response()->json(["status"=>false,
                                                    "message"=>"Username tidak tersedia.",
                                                    "data"=>$data],200); 
                            die();
                        }
                    }
                    

                    $data->role_id      = $request->role;
                    $data->username     = $request->username;
                    $data->fullname     = $request->fullname;
                    $data->email        = $request->email;
                    $data->status       = $request->status;
                    if($request->has('password'))
                    {
                        $data->password     = Hash::make($request->password);
                    }
                    $data->save();
                        
                    return response()->json(["status"=>true,
                                            "message"=>"Berhasil menyimpan data",
                                            "data"=>$data],200);
                }else{

                    return response()->json(["status"=>false,
                                            "message"=>"Data tidak ditemukan",
                                            "data"=>[]],200);

                }
                   
            }else{
                return response()->json(["status"=>false,
                                        "message"=>$validator->messages(),
                                        "data"=>[]],200);
            }

        }catch(\Exception $e){
           return response()->json(["status"=>false,
                                    "message"=>"Oops there is some error with system,please try again letter",
                                    "data"=>[]],200);
        } 
    }

    /**
     * destroy data
     *
     * @return void
     */
    public function destroy(Request $request)
    {
        if($request->has('id'))
        {
            $data  = User::find($request->id);
            if(count($data))
            {
                $data->delete();
                return response()->json(["status"=>true,
                                    "message"=>"Berhasil menghapus data"],200);

            }else{
                return response()->json(["status"=>false,
                                    "message"=>"Data tidak ditemukan"],200);
            }
        }
        else
        {
            return response()->json(["status"=>false,
                                    "message"=>"ID tidak boleh kosong"],200);          
        }
        
    }

}
