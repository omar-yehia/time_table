<?php

namespace App\Http\Controllers;

use App\Time;
use App\User;
use App\Pharmacy;
use Illuminate\Http\Request;


class TimeController extends Controller
{
 
    public function index()
    {
        $allTimes=Time::orderBy('date')->get();

        foreach($allTimes as $time){
            $user_name=User::find($time->user_id);
            $time->user=$user_name->name;
            $pharmacy_name=Pharmacy::find($time->pharmacy_id);
            $time->pharmacy=$pharmacy_name->name;
            $time->day=date('l',strtotime($time->day));
            $time->date=date('d-m-Y',strtotime($time->date));
            $time->start_time=date('h:i A',strtotime($time->start_time));
            $time->end_time=date('h:i A',strtotime($time->end_time));
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

    // take user_id or pharmacy id or return all times
    public function getListOfTimes(Request $request){
        // dd($request->all());

        //user seeing his times
        $user_id=session('authorized_user');
        
        if($user_id){
            $times=Time::where('user_id',$user_id);
        }else{
            $allowed_admin=session('authorized_admin') && in_array('times',session('admin_permissions'));
            if(!$allowed_admin){return ['return'=>0,'html'=>''];}
    
            //admin seeing pharmacy's times
            $pharmacy_id=$request->pharmacy_id;
            if($pharmacy_id) $times=Time::where('pharmacy_id',$pharmacy_id);
            else{
                //admin seeing all times
                $times=Time::query();
            }
        }

        $pharmacy_name=$request->pharmacy_name;
        $daterange=explode(' - ',$request->daterange);
        $start_date=count($daterange)>0?date('Y-m-d',strtotime($daterange[0])):'';
        $end_date=count($daterange)>1?date('Y-m-d',strtotime($daterange[1])):'';

        if($pharmacy_name){
            $pharmacies=Pharmacy::where('name','LIKE',"%$pharmacy_name%")->get();
            $pharmacies_ids=[];
            if($pharmacies){ $pharmacies_ids=$pharmacies->pluck('id')->toArray();}

            $times->whereIn('pharmacy_id',$pharmacies_ids);
        }
        if($start_date && $end_date){
            $times->whereBetween('date',[$start_date,$end_date]);
        }
        $times=$times->orderBy('date')->get();

        foreach($times as $time){
            $user=User::find($time->user_id);
            $time->user=$user->name;
            $pharmacy_name=Pharmacy::find($time->pharmacy_id);
            $time->pharmacy=$pharmacy_name->name;
            $time->day=date('l',strtotime($time->day));
            $time->date=date('d-m-Y',strtotime($time->date));
            $time->start_time=date('h:i A',strtotime($time->start_time));
            $time->end_time=date('h:i A',strtotime($time->end_time));
        }

        $html_list_times=view('admin.list_times')->with([
            'times'=>$times,
            ])->render();

        return ['return'=>1,'html_list_times'=>$html_list_times];
    }
 
    public function create(Request $request)
    {
        $valid_admin=session('authorized_admin') && in_array('users',session('admin_permissions'));
        $valid_user=session('authorized_user');
        if($valid_user){ $user_id=$valid_user;}
        else if($valid_admin){$user_id=$request->user_id;}
        else{$this->logout();}

        
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
        
        $success=Time::insert([
            'user_id'=>$user_id,
            'pharmacy_id'=>$pharmacy_id,
            'day'=>$day,
            'date'=>$date,
            'start_time'=>$start_time,
            'end_time'=>$end_time,
        ]);

        if($success){ return ['return'=>1,'html'=>""]; }
        return ['return'=>0,'html'=>""];

    }

    public function deleteTime(Request $request)
    {
        $id=$request->id;
        $deleted=Time::where('id',$id)->delete();
        return $deleted;
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
            $time->start_time=date('h:i A',strtotime($time->start_time));
            $time->end_time=date('h:i A',strtotime($time->end_time));
        }

        $times=$times->sortBy('date');
        return view('admin.view_times')->with([
            'times'=>$times,
            'username'=>$user->name
        ])->render();
    }

    public function editTime(Request $request){
        // dd($request->all());
        $time=Time::find($request->id);
        if(!$time){ return ['return'=>0,'html'=>""];}
        
        $allPharmacies=Pharmacy::all();
        $allUsers=[];
        if(session('authorized_admin')){ $allUsers=User::all();}

        $html=view('admin.edit_time')->with([
            'time'=>$time,
            'allPharmacies'=>$allPharmacies,
            'allUsers'=>$allUsers,
        ])->render();

        return ['return'=>1,'html'=>$html];
    }
    public function updateTime(Request $request){
        $time_id=$request->time_id;
        $user_id=$request->user_id;
        $pharmacy_id=$request->pharmacy_id;
        $date=date('Y-m-d',strtotime($request->date));
        $day=date('l',strtotime($date));
        $start_time=date('H:i',strtotime($request->start_time));
        $end_time=date('H:i',strtotime($request->end_time));

        $allUserTimes=Time::where('user_id',$user_id)->whereDate('date',$date)->where('id','!=',$time_id)->get();
        // dd($allUserTimes);
        foreach ($allUserTimes as $time) {
            if($this->check_collision($start_time,$end_time,$time->start_time,$time->end_time)){
                $starttime=date('h:i A',strtotime($time->start_time));
                $endtime=date('h:i A',strtotime($time->end_time));
                return ['return'=>0,'html'=>"a collision occured with $time->date from $starttime to $endtime"];
            }
        }
        
        $success=Time::where('id',$time_id)->update([
            'user_id'=>$user_id,
            'pharmacy_id'=>$pharmacy_id,
            'day'=>$day,
            'date'=>$date,
            'start_time'=>$start_time,
            'end_time'=>$end_time,
        ]);
        
        return ['return'=>1,'html'=>""];

    }
    

}
