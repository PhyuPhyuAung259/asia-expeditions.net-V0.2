<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Tour;
use App\Project;
use App\Booking; 
use App\BookTransport; 
use App\BookRestaurant;
use App\BookEntrance;
use App\Supplier;
use App\BookMisc;
use App\BookGuide; 
use App\HotelBooked; 
use App\CruiseBooked;
class EditOperationController extends Controller
{
    //
    public function editOperation(Request $request, $type, $id){
       
        if($type =="entrance"){
            $editentrance=BookEntrance::find($id);
             return view("admin/operation/editentrance",compact ('editentrance'));
        }
        if($type =="restaurant"){
            $editrestaurant=BookRestaurant::find($id);
             return view("admin/operation/editrestaurant",compact ('editrestaurant'));
        }
        if($type =="Transport"){
           
            $editTran=DB::table('transport_book')->where('book_id',$id)->first();
            $btransport=Booking::where(['id'=>$id,'book_project'=>$request->project_no,'tour_id'=>$request->tour_id])->first();
           
            if($request->sub_type == "additional transport"){
                
                return view("admin/operation/additional_transport_booking",compact ('editTran','btransport'));
              
            }else {
            return view("admin/operation/editTransport",compact ('editTran','btransport'));}
        }
        if($type=="misc"){
            //$editmisc=DB::table('misc_book')->where('book_id',$id)->first();
            $bmisc=Booking::where(['id'=>$id,'book_project'=>$request->project_no,'tour_id'=>$request->tour_id])->first();
            
            return view("admin/operation/editmisc",compact ('bmisc'));
        }
    }

    public function editGuideOperation(Request $request,$type,$project_no, $id){
        $guide=BookGuide::where(['project_number'=>$project_no,'book_id'=>$id])->first();
        $btour=Booking::where(['id'=>$id,'book_project'=>$project_no,'tour_id'=>$request->tour_id])->first();
        return view("admin/operation/editguide",compact ('guide','btour'));
    }  
}

