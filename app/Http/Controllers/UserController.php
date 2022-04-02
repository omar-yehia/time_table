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
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(empty(session('authorized_admin'))){return $this->logout();}

        $allUsers=User::all();
        return view('admin.users')->with([
            'allUsers'=>$allUsers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(empty(session('authorized_admin'))){return ['return'=>0,'html'=>""];}
        $success=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);

        if($success){
            $allUsers=User::all();
            return ['return'=>1,'html'=>view('admin.users')->with(['allUsers'=>$allUsers])->render()];
        }
        else{
            return ['return'=>0,'html'=>""];
        }
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
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
