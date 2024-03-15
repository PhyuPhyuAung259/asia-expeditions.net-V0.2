<?php

namespace App\Http\Controllers\Admin;


use App\Project;
use App\Promotion;
use App\component\Content;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PromotionController extends Controller
{
    //
    public function getPromotion(Request $request){
        $promotion = Promotion::where('status', 1)->get();
        return view('admin.hotel.promotion.promotionList', compact('promotion'));
    }

    public function addPromotion(Request $request){
        return view('admin.hotel.promotion.addPromotion');
    }

    public function storePromotion(Request $request){
        $promotion=new Promotion;
        $promotion->name=$request->name;
        $promotion->description=$request->description;
        $promotion->hotel_id=$request->hotel;
        $promotion->start_date=$request->start_date;
        $promotion->end_date=$request->end_date;
        $promotion->promotion_rate=$request->promotion_rate;
        $promotion->status=1;
        $promotion->save();
        return redirect(route('getPromotion'))->with(['message'=> "Promotion has been added successfully",  'status'=> 'success', 'status_icon'=> 'fa-check-circle']); 
    }

    public function getEditSupplier($promoId){
        $promotion = Promotion::find($promoId);
        if (empty($promotion)) {
            $message =  $promoId;
            return view('errors.error', compact('message', 'type'));
        }
        return view('admin.hotel.promotion.promotionFromEdit', compact('promotion'));
    }
 


}
