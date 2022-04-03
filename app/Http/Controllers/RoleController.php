<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
 
    public function index()
    {
        $all_roles=Role::all();
        return view('admin.roles')->with(['all_roles'=>$all_roles]);
    }
 
    public function create(Request $request)
    {
        // dd($request->all());
        $success=Role::insert([
            'name'=>$request->name,
            'description'=>$request->description,
        ]);

        if($success){
            $all_roles=Role::all();
            return ['return'=>1,'html'=>view('admin.roles')->with(['all_roles'=>$all_roles])->render()];
        }
        else{
            return ['return'=>0,'html'=>""];
        }
    }

    public function getListOfRoles(){
        $allowed_admin=session('authorized_admin') && in_array('roles',session('admin_permissions'));
        if(!$allowed_admin){return ['return'=>0,'html'=>''];}
        $roles=Role::all();

        $html=view('admin.list_roles')->with([
            'roles'=>$roles,
            ])->render();

        return ['return'=>1,'html'=>$html];
    }
    public function editRole(Request $request)
    {
        $id=$request->id;
        $valid_admin=session('authorized_admin') && in_array('roles',session('admin_permissions'));
        if(!$valid_admin){$this->logout();}
        $role=Role::find($id);
        if(!$role) return ['return'=>0,''];

        $html=view('admin.edit_role')->with(['role'=>$role])->render();
        return ['return'=>1,'html'=>$html];
    }
    public function updateRole(Request $request){
        $role_id=$request->role_id;
        $name=$request->name;
        $description=$request->description;
        $success=Role::where('id',$role_id)->update([
            'name'=>$name,
            'description'=>$description,
        ]);
        return ['return'=>1,'html'=>""];
    }
    public function deleteRole(Request $request)
    {
        $id=$request->id;
        $role=Role::find($id);
        if(!$role) return ['return'=>0,'html'=>"couldn't delete"];
        $role->delete();

        ['return'=>1,'html'=>""];
    }
}
