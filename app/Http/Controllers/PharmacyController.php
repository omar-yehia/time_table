<?php

namespace App\Http\Controllers;

use App\Pharmacy;
use Illuminate\Http\Request;

class PharmacyController extends Controller
{
 /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $allPharmacies=Pharmacy::all();
        return view('admin.pharmacies')->with([
            // 'allPharmacies'=>$allPharmacies
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $success=Pharmacy::insert(['name'=>$request->name]);
        return ['return'=>1,'html'=>''];
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
     * @param  \App\Pharmacy  $pharmacy
     * @return \Illuminate\Http\Response
     */
    public function show(Pharmacy $pharmacy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pharmacy  $pharmacy
     * @return \Illuminate\Http\Response
     */
    public function edit(Pharmacy $pharmacy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pharmacy  $pharmacy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pharmacy $pharmacy)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pharmacy  $pharmacy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pharmacy $pharmacy)
    {
        //
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
