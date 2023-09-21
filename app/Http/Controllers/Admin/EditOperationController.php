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
        //  dd($editTran);
            return view("admin/operation/editTransport",compact ('editTran'));
        }
    }

    public function editGuideOperation(Request $request,$type,$project_no, $id){
      // dd( $project_no);
        $guide=BookGuide::where(['project_number'=>$project_no,'book_id'=>$id])->first();
        return view("admin/operation/editguide",compact ('guide'));
    }
}

