<?php

namespace App\Http\Controllers;

use App\Pharmacy;
use Illuminate\Http\Request;

class PharmacyController extends Controller
{

    public function index()
    {
        return view('admin.pharmacies');
    }

    public function create(Request $request)
    {
        $success=Pharmacy::insert(['name'=>$request->name]);
        return ['return'=>1,'html'=>''];
    }
    
    public function getListOfPharmacies(){
        $allowed_admin=session('authorized_admin') && in_array('pharmacies',session('admin_permissions'));
        if(!$allowed_admin){return ['return'=>0,'html'=>''];}
        $pharmacies=Pharmacy::all();

        $html=view('admin.list_pharmacies')->with([
            'pharmacies'=>$pharmacies,
            ])->render();

        return ['return'=>1,'html'=>$html];
    }

    public function editPharmacy(Request $request)
    {
        $id=$request->id;
        $valid_admin=session('authorized_admin') && in_array('pharmacies',session('admin_permissions'));
        if(!$valid_admin){$this->logout();}
        $pharmacy=Pharmacy::find($id);
        if(!$pharmacy) return ['return'=>0,''];

        $html=view('admin.edit_pharmacy')->with(['pharmacy'=>$pharmacy])->render();
        return ['return'=>1,'html'=>$html];
    }
    public function updatePharmacy(Request $request){
        $pharmacy_id=$request->pharmacy_id;
        $name=$request->name;
        
        $success=Pharmacy::where('id',$pharmacy_id)->update(['name'=>$name]);
        return ['return'=>1,'html'=>""];
    }
    public function deletePharmacy(Request $request)
    {
        $id=$request->id;
        $pharmacy=Pharmacy::find($id);
        if(!$pharmacy) return ['return'=>0,'html'=>"couldn't delete"];
        $pharmacy->times()->delete();
        $pharmacy->delete();

        ['return'=>1,'html'=>""];
    }
    
}
