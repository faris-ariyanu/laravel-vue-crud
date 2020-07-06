<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Role;
use App\Entities\RoleMenu;
use Validator;

class RoleController extends Controller
{
    /**
     * query to get data
     *
     * @return void
     */
    public function index(Request $request)
    {
        try {

            $Query      = Role::with('menu')
                            ->with('status');

            if($request->has('id'))
            {
                $Query  = $Query->where("sys_role.id",$request->id)
                                ->first();
                $iTotal     = count($Query);

            }else{

                if($request->has('search')){
                    $Query    = $Query->where(function ($query) use($request) {
                                    $query->orWhereRaw("lower(sys_role.name) like '%".$request->search."%'");
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
        $rule       = ['name' => 'required|max:125',
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

            $validator  = Validator::make($request->all(), self::rule());
            if (!$validator->fails()) 
            {   
                $data               = new Role;
                $data->name         = $request->name;
                $data->status       = $request->status;
                if($data->save())
                {
                    self::storeItem($data->id,$request->role);    
                }

                return response()->json(["status"=>true,
                                        "message"=>"Berhasil menyimpan data",
                                        "data"=>$data],200);   

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

    public function storeItem($id,$roles)
    {
        if(count($roles))
        {
            foreach($roles as $role){
                if($role['role']['create']==1 ||
                    $role['role']['read']==1 ||
                    $role['role']['update']==1 ||
                    $role['role']['delete']==1)
                {
                    $data           = new RoleMenu;
                    $data->role_id  = $id;
                    $data->menu_id  = $role['menu_id'];
                    $data->role_menu= json_encode($role['role']);
                    $data->save();
                }
            }
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
                $data               = Role::find($request->id);
                if(count($data))
                {
                    $data->name         = $request->name;
                    $data->status       = $request->status;
                    if($data->save())
                    {
                        RoleMenu::where("role_id",$request->id)->delete();
                        self::storeItem($request->id,$request->role);    
                    }
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
            $data  = Role::find($request->id);
            if(count($data))
            {
                RoleMenu::where("role_id",$request->id)->delete();
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
