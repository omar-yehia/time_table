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
            session()->forget('authorized_admin');
            session()->put('authorized_admin',$admin->id);

            return redirect()->route('dashboard');
        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_admins=Admin::all();
        $all_roles=Role::all();
        return view('admin/admins')->with([
            'all_admins'=>$all_admins,
            'all_roles'=>$all_roles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        dd($request->all());
        // roles
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }

    public function dashboard()
    {
        if(empty(session('authorized_admin'))){ return $this->logout();}
        $number_of_users=User::count();
        $number_of_pharmacies=Pharmacy::count();
        $number_of_admins=Admin::count();
        $number_of_times=Time::count();
        $number_of_roles=Role::count();
        
        return view('admin.dashboard')->with([
            'number_of_users'=>$number_of_users,
            'number_of_pharmacies'=>$number_of_pharmacies,
            'number_of_admins'=>$number_of_admins,
            'number_of_times'=>$number_of_times,
            'number_of_roles'=>$number_of_roles,
        ]);


    }
    
}
