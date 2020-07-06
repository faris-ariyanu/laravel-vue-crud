<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Menu;
use Validator;

class MenuController extends Controller
{
    /**
     * query to get data
     *
     * @return void
     */
    public function index(Request $request)
    {
        try {

            $Query      = Menu::with('status');

            if($request->has('id'))
            {
                $Query  = $Query->where("sys_menu.id",$request->id)
                                ->first();
                $iTotal     = count($Query);

            }else{

                if($request->has('search')){
                    $Query    = $Query->where(function ($query) use($request) {
                                    $query->orWhereRaw("lower(sys_menu.name) like '%".$request->search."%'");
                                });
                }
                
                $iTotal     = count($Query->get());
                
                if($request->has('parent')){
                    $Query    = $Query->where("parent",$request->parent);
                }

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
                        'sequence' => 'required|max:4',
                        'parent' => 'required|max:9',
                        'url' => 'required',
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
                $data               = new Menu;
                $data->name         = $request->name;
                $data->url          = $request->url;
                $data->sequence     = $request->sequence;
                $data->parent       = $request->parent;
                $data->menu_value   = $request->has('icon')?$request->icon:"";
                $data->status       = $request->status;
                $data->save();
                    
                return response()->json(["status"=>true,
                                        "message"=>"Berhasil menyimpan data",
                                        "data"=>[]],200);   

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
                $data               = Menu::find($request->id);
                if(count($data))
                {
                    $data->name         = $request->name;
                    $data->url          = $request->url;
                    $data->sequence     = $request->sequence;
                    $data->parent       = $request->parent;
                    $data->menu_value   = $request->has('icon')?$request->icon:"";
                    $data->status       = $request->status;
                    $data->save();
                        
                    return response()->json(["status"=>true,
                                            "message"=>"Berhasil menyimpan data",
                                            "data"=>[]],200);
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
            $data  = Menu::find($request->id);
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
