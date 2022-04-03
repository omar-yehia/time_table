<?php

namespace App\Http\Controllers;

use App\User;
use App\Time;
use App\Pharmacy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;

class UserController extends Controller
{

    public function logout(){
        Session::flush();
        return redirect()->route('login_page');
    }

    public function home(Request $request){
        $user_id=session('authorized_user');
        if(empty($user_id)){return $this->logout();}
        $user=User::find($user_id);
        return view('users.home')->with([
            'user'=>$user,
        ]);
    }
     
    public function index()
    {
        if(empty(session('authorized_admin'))){return $this->logout();}

        $allUsers=User::all();
        return view('admin.users')->with([
            'allUsers'=>$allUsers
        ]);
    }
 
    public function create(Request $request)
    {
        if(empty(session('authorized_admin'))){return ['return'=>0,'html'=>""];}
        $success=User::insert([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);

        if($success){ return ['return'=>1,'html'=>''];}
        return ['return'=>0,'html'=>''];
    }
 
    public function getListOfUsers(){
        $allowed_admin=session('authorized_admin') && in_array('users',session('admin_permissions'));
        if(!$allowed_admin){return ['return'=>0,'html'=>''];}
        $users=User::all();

        $html=view('admin.list_users')->with([
            'users'=>$users,
            ])->render();

        return ['return'=>1,'html'=>$html];
    }
    public function editUser(Request $request)
    {
        $id=$request->id;
        $valid_admin=session('authorized_admin') && in_array('users',session('admin_permissions'));
        if(!$valid_admin){$this->logout();}
        $user=User::find($id);
        if(!$user) return ['return'=>0,''];

        $html=view('admin.edit_user')->with(['user'=>$user])->render();
        return ['return'=>1,'html'=>$html];
    }
    public function updateUser(Request $request){
        $user_id=$request->user_id;
        $data['name']=$request->name;
        $data['email']=$request->email;
        $password=$request->password;
        if($password){
            $data['password']=Hash::make($password);
        }
        
        $success=User::where('id',$user_id)->update($data);
        return ['return'=>1,'html'=>""];
    }
    public function deleteUser(Request $request)
    {
        $id=$request->id;
        $user=User::find($id);
        if(!$user) return ['return'=>0,'html'=>"couldn't delete"];
        $user->times()->delete();
        $user->delete();

        ['return'=>1,'html'=>""];
    }

}
