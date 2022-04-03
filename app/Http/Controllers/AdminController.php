<?php

namespace App\Http\Controllers;

use App\Admin;
use App\User;
use App\Pharmacy;
use App\Time;
use App\Role;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;

class AdminController extends Controller
{

    public function logout(){
        Session::flush();
        return redirect()->route('login_page');
    }

    function login_page(Request $request){
        if(session('authorized_admin')){ return redirect()->route('dashboard');}
        if(session('authorized_user')){ return redirect()->route('home');}
        return view('admin.login');
    }

    function login(Request $request){
        $accounttype=$request->accounttype;
        $email=$request->email;
        if($accounttype=='user'){
            $user=User::where('email',$email)->first();
            if(!$user){return redirect()->back()->with('error','Wrong Credentials');}
            
            $password=Hash::check($request->password,$user->password);
            if(!$password){return redirect()->back()->with('error','Wrong Credentials');}    
            session()->forget('authorized_user');
            session()->put('authorized_user',$user->id);

            return redirect()->route('home');
        }elseif($accounttype=='admin'){
            $admin=Admin::where('email',$email)->first();
            if(!$admin){return redirect()->back()->with('error','Wrong Credentials');}

            $password=Hash::check($request->password,$admin->password);
            if(!$password){return redirect()->back()->with('error','Wrong Credentials');}    

            session()->forget('admin_permissions');
            session()->put('admin_permissions',explode(',',$admin->roles));

            session()->forget('authorized_admin');
            session()->put('authorized_admin',$admin->id);

            return redirect()->route('dashboard');
        }

    }
 
    public function index()
    {
        $all_admins=Admin::all();
        $all_roles=Role::all();
        return view('admin/admins')->with([
            'all_admins'=>$all_admins,
            'all_roles'=>$all_roles,
        ]);
    }
 
    public function create(Request $request)
    {
        $data['name']=$request->name;
        $data['email']=$request->email;
        $data['password']=Hash::make($request->password);
        $data['roles']=implode(',',$request->roles);
        
        $success=Admin::insert($data);
        return ['return'=>1,'html'=>""];
    }
    public function dashboard()
    {
        if(empty(session('authorized_admin'))){ return $this->logout();}
        return view('admin.dashboard');
    }

    public function getStats(){
        if(empty(session('authorized_admin'))){ return $this->logout();}
        $number_of_users=User::count();
        $number_of_pharmacies=Pharmacy::count();
        $number_of_admins=Admin::count();
        $number_of_times=Time::count();
        $number_of_roles=Role::count();
        
        $html=view('admin.stats')->with([
            'number_of_users'=>$number_of_users,
            'number_of_pharmacies'=>$number_of_pharmacies,
            'number_of_admins'=>$number_of_admins,
            'number_of_times'=>$number_of_times,
            'number_of_roles'=>$number_of_roles,
        ])->render();

        return ['return'=>1,'html'=>$html];
    }
    
    public function getListOfAdmins(){
        $allowed_admin=session('authorized_admin') && in_array('admins',session('admin_permissions'));
        if(!$allowed_admin){return ['return'=>0,'html'=>''];}
        $admins=Admin::all();

        $html=view('admin.list_admins')->with([
            'admins'=>$admins,
            ])->render();

        return ['return'=>1,'html'=>$html];
    }
    public function editAdmin(Request $request)
    {
        $id=$request->id;
        $valid_admin=session('authorized_admin') && in_array('admins',session('admin_permissions'));
        if(!$valid_admin){$this->logout();}
        $admin=Admin::find($id);
        if(!$admin) return ['return'=>0,''];
        $all_roles=Role::all();

        $html=view('admin.edit_admin')->with(['admin'=>$admin,'all_roles'=>$all_roles])->render();
        return ['return'=>1,'html'=>$html];
    }
    public function updateAdmin(Request $request){
        $admin_id=$request->admin_id;
        $data['name']=$request->name;
        $data['email']=$request->email;
        $password=$request->password;
        if($password){
            $data['password']=Hash::make($password);
        }
        $data['roles']=implode(',',$request->roles);
        
        $success=Admin::where('id',$admin_id)->update($data);
        return ['return'=>1,'html'=>""];
    }
    public function deleteAdmin(Request $request)
    {
        $id=$request->id;
        $admin=Admin::find($id);
        if(!$admin) return ['return'=>0,'html'=>"couldn't delete"];
        $admin->delete();

        ['return'=>1,'html'=>""];
    }
}
