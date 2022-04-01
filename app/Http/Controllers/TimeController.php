<?php

namespace App\Http\Controllers;

use App\Time;
use App\User;
use App\Pharmacy;
use Illuminate\Http\Request;


class TimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allTimes=Time::all();

        foreach($allTimes as $time){
            $user_name=User::find($time->user_id);
            $time->user=$user_name->name;
            $pharmacy_name=Pharmacy::find($time->pharmacy_id);
            $time->pharmacy=$pharmacy_name->name;
            $time->day=date('l',strtotime($time->day));
            $time->date=date('d-m-Y',strtotime($time->date));
            $time->start_time=date('H:i A',strtotime($time->start_time));
            $time->end_time=date('H:i A',strtotime($time->end_time));
        }

        $allPharmacies=Pharmacy::all();
        $allUsers=User::all();
        return view('admin.times')->with([
            'allTimes'=>$allTimes,
            'allPharmacies'=>$allPharmacies,
            'allUsers'=>$allUsers,
        ]);
    }

    public function check_collision($start_time,$end_time,$start_time_old,$end_time_old){
        $start_new=strtotime($start_time);
        $end_new=strtotime($end_time);
        $start_old=strtotime($start_time_old);
        $end_old=strtotime($end_time_old);
        $col_1= ($start_new<=$start_old) && ($end_new>=$end_old);           //slot is containing or coinciding with used range
        $col_2=  ($start_old <= $start_new) && ($start_new <= $end_old);    //start is between used range
        $col_3=  ($start_old <= $end_new) && ($end_new <= $end_old);        //end is between used range

        if($col_1||$col_2||$col_3) return true;
        else return false;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // dd($request->all());
        $single_user_data=$request->single_user_data?1:0;
        $user_id=$request->user_id;
        $pharmacy_id=$request->pharmacy_id;
        $date=date('Y-m-d',strtotime($request->date));
        $day=date('l',strtotime($date));
        $start_time=date('H:i',strtotime($request->start_time));
        $end_time=date('H:i',strtotime($request->end_time));

        $allUserTimes=Time::where('user_id',$user_id)->where('date',$date)->get();
        foreach ($allUserTimes as $time) {
            if($this->check_collision($start_time,$end_time,$time->start_time,$time->end_time)){
                $starttime=date('h:i A',strtotime($time->start_time));
                $endtime=date('h:i A',strtotime($time->end_time));
                return ['return'=>0,'html'=>"a collision occured with $time->date from $starttime to $endtime"];
            }
        }
        
        $success=Time::create([
            'user_id'=>$user_id,
            'pharmacy_id'=>$pharmacy_id,
            'day'=>$day,
            'date'=>$date,
            'start_time'=>$start_time,
            'end_time'=>$end_time,
        ]);

        if($success){
            if(!$single_user_data){
                $allTimes=Time::all();
            }else{
                $allTimes=Time::where('user_id',$user_id)->get();
            }
            foreach($allTimes as $time){
                $user_name=User::find($time->user_id);
                $time->user=$user_name->name;
                $pharmacy_name=Pharmacy::find($time->pharmacy_id);
                $time->pharmacy=$pharmacy_name->name;
                $time->day=date('l',strtotime($time->day));
                $time->date=date('d-m-Y',strtotime($time->date));
                $time->start_time=date('H:i A',strtotime($time->start_time));
                $time->end_time=date('H:i A',strtotime($time->end_time));
            }
            return ['return'=>1,'html'=>view('admin.list_times')->with([
                'allTimes'=>$allTimes,
                ])->render()];
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
     * @param  \App\Time  $time
     * @return \Illuminate\Http\Response
     */
    public function show(Time $time)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Time  $time
     * @return \Illuminate\Http\Response
     */
    public function edit(Time $time)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Time  $time
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Time $time)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Time  $time
     * @return \Illuminate\Http\Response
     */
    public function destroy(Time $time)
    {
        //
    }

    public function createRowsFromDateRange(Request $request){
        $allPharmacies=Pharmacy::all();
        // $allUsers=User::all();

        $start= strtotime($request->start);
        $end= strtotime($request->end);
        $datediff = $end - $start;
        $diff=(int) round($datediff / (60 * 60 * 24));

        $htmlPharmacy="";
        foreach($allPharmacies as $pharmacy){
            $htmlPharmacy.="<option value='$pharmacy->id'>$pharmacy->name</option>";
        }

        $html="";
        for($i=0;$i<=$diff;$i++){
            $currDate=date('d-m-Y',strtotime($request->start." +$i days"));
            $currDay=date('l',strtotime($request->start." +$i days"));
            $html.="
                <form class='create_form'>
                 <div class='row'>
                    <input type='hidden' name='date' value='".$currDate."'>
                    <div class='col-md-2'>".$currDate.' '.$currDay."</div>
                    <div class='col-md-2'><select name='pharmacy_id'>".$htmlPharmacy."</select></div>
                    <div class='col-md-2'><input type='time' name='start_time' required></div>
                    <div class='col-md-2'><input type='time' name='end_time' required></div>
                    <div class='col-md-2'><button>Create</button></div>
                </div>
                
                </form>
                ";
        }
        return $html;        
    }
    public function view_user_times(Request $request){
        $user=User::find($request->id);
        $times=[];
        if($user){
            $times=$user->times;
        }

        foreach($times as $time){
            $time->user=$user->name;
            $pharmacy_name=Pharmacy::find($time->pharmacy_id);
            $time->pharmacy=$pharmacy_name->name;
            $time->day=date('l',strtotime($time->day));
            $time->date=date('d-m-Y',strtotime($time->date));
            $time->start_time=date('H:i A',strtotime($time->start_time));
            $time->end_time=date('H:i A',strtotime($time->end_time));
        }

        return view('admin.view_times')->with([
            'times'=>$times,
            'username'=>$user->name
        ])->render();
    }
}
