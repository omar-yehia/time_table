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
        // dd($request->all());
        if(empty(session('authorized_user'))){return $this->logout();}

        $user_id=session('authorized_user');
        $pharmacy_name=$request->pharmacy_name;
        $daterange=explode(' - ',$request->daterange);
        $start_date=count($daterange)>0?date('Y-m-d',strtotime($daterange[0])):'';
        $end_date=count($daterange)>1?date('Y-m-d',strtotime($daterange[1])):'';

        // dd($start_date,$end_date);
        // $start_date="2022-01-01";
        // $end_date="2022-10-01";
        $user_times=Time::where('user_id',$user_id);
        if($pharmacy_name){
            $pharmacies=Pharmacy::where('name','LIKE',"%$pharmacy_name%")->get();
            $pharmacies_ids=[];
            if($pharmacies){ $pharmacies_ids=$pharmacies->pluck('id')->toArray();}

            $user_times->whereIn('pharmacy_id',$pharmacies_ids);
        }
        if($start_date && $end_date){
            $user_times->whereBetween('date',[$start_date,$end_date]);
        }
        $user_times=$user_times->get();
        // dd($user_times->toSql());
        $user=User::find($user_id);
        foreach($user_times as $time){
            $time->user=$user->name;
            $pharmacy_name=Pharmacy::find($time->pharmacy_id);
            $time->pharmacy=$pharmacy_name->name;
            $time->day=date('l',strtotime($time->day));
            $time->date=date('d-m-Y',strtotime($time->date));
            $time->start_time=date('H:i A',strtotime($time->start_time));
            $time->end_time=date('H:i A',strtotime($time->end_time));
        }
        return view('users.home')->with([
            'user'=>$user,
            'user_times'=>$user_times,
            'search_pharmacy_name'=>$request->pharmacy_name,
            'search_date_range'=>$request->daterange,
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
