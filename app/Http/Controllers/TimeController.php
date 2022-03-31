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
        $allPharmacies=Pharmacy::all();
        $allUsers=User::all();
        return view('admin.times')->with([
            'allTimes'=>$allTimes,
            'allPharmacies'=>$allPharmacies,
            'allUsers'=>$allUsers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // dd($request->all());
        $user_id=$request->user_id;
        $pharmacy_id=$request->pharmacy_id;
        $date=$request->date;
        $day=date('l',strtotime($date));
        $start_time=date('H:i',strtotime($request->start_time));
        $end_time=date('H:i',strtotime($request->end_time));

        $success=Time::create([
            'user_id'=>$user_id,
            'pharmacy_id'=>$pharmacy_id,
            'day'=>$day,
            'date'=>$date,
            'start_time'=>$start_time,
            'end_time'=>$end_time,
        ]);

        if($success) return 1;
        else return 0;
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
            $currDate=date('d-m-y',strtotime($request->start." +$i day"));
            $currDay=date('l',strtotime($currDate));
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
}
