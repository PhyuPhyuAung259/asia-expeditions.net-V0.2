
@extends('layout.backend')
@section('title', 'Hotel booking report')
<?php 
$total_no_of_booked_night=0;
?>
@section('content')
	<div class="col-lg-12">
    <table style="margin-top:10px;">
     
        @if(!empty($hotel))
          <?php  $hotel_info= DB::table('suppliers')->where('id', $hotelid)->first(); ?>
          <tr>
            <tr>
              <td>Hotel Name &nbsp;&nbsp; : &nbsp;&nbsp; {{$hotel_info->supplier_name}}</td>
            </tr>
            <tr>
              <td>Contact Name &nbsp;&nbsp;:&nbsp;&nbsp; {{{$hotel_info->supplier_contact_name or ''}}}</td>
            </tr>
            <tr>
              <td>Phone &nbsp;&nbsp;:&nbsp;&nbsp; {{{$hotel_info->supplier_phone or ''}}}</td>
            </tr>
            <tr>
              <td>Email &nbsp;&nbsp;:&nbsp;&nbsp; {{{$hotel_info->supplier_email or ''}}}</td>
            </tr>
            <tr>
              <td>Address &nbsp;&nbsp;:&nbsp;&nbsp; {{{$hotel_info->supplier_address or ''}}}</td>
            </tr> 
            <tr>
              <td>Website &nbsp;&nbsp;:&nbsp;&nbsp; {{{$hotel_info->supplier_website or ''}}}</td>
            </tr>
          </tr>
        @endif
    </table>
    <div class="pull-right hidden-print">
      <a href="javascript:void(0)" onclick="window.print();"><span class="fa fa-print btn btn-primary"> Print</span></a>&nbsp;&nbsp;&nbsp;&nbsp;
		</div>

		<div class="text-center mt-5 "> <span class="pull-left"> <h4>From {{$startDate or ''}} : To {{$endDate or ''}} </h4></span> <h3> <strong class="btborder " style="text-transform: uppercase;"> {{$hotel_info->supplier_name}} Booking Report</strong></h3></div>
    <table id="firstDt" class=" datatable table-hover table-striped table-bordered dt-responsive" cellspacing="0" width="100%" >
      <thead>
        <tr>
          <th rowspan="2">Client Infomation</th>
          <th rowspan="2">Agent Name</th>
          <th colspan="11">Booking Details</th>
        </tr>
        <tr>
          <th>Check In</th>
          <th>Check Out</th>
          <th>Room</th>
          <th>No of Room</th>
          <th>Booked Night</th>
          <th>Net single</th>
          <th>Net Double</th>
          <th>Net Twin</th>
          <th>Net Extra</th>
          <th>Net Chextra</th>
          <th>Net Amount</th>
        </tr>
      </thead>
      <tbody>
        @if(!empty($hotel))
        @foreach($hotel as $hotels)
        <?php $hotelb= DB::table("hotelb")->where(['project_number'=>$hotels->book_project,'hotel_id'=>$hotels->hotel_id])->first();?>
         @if(!empty($hotelb->project_number))
        <?php $client_info= DB::table("project_client_name")->where('project_number', $hotelb->project_number)->get(); ?>
            <tr>
              <td>
                Project Number &nbsp;&nbsp; : &nbsp;&nbsp; {{{$client_info->project_number or $hotels->book_project}}} <br>
                Client Name &nbsp;&nbsp; : &nbsp;&nbsp; {{{$client_info->client_name or $hotels->book_client}}} <br>
                Phone &nbsp;&nbsp; : &nbsp;&nbsp; {{{$client_info->phone or ''}}} <br>
              </td>
              <td><?php $agent=DB::table("suppliers")
                              ->join('booking', 'suppliers.id', '=', 'booking.book_agent')
                              ->where('booking.book_project','=',$hotelb->project_number)
                              ->whereNotNull('booking.book_agent')
                              ->first();?>
                              {{{$agent->supplier_name or ''}}}</td>
              <td>{{{$hotelb->checkin or ''}}}</td>
              <td>{{{$hotelb->checkout or ''}}}</td>
              <td><?php $room= DB::table("room")->where('id', $hotelb->room_id)->first(); ?>{{{ $room->name or ''}}}</td>
              <td>{{{$hotelb->no_of_room or ''}}}</td>
              <td>{{{$hotelb->book_day or ''}}}</td>
              <td>{{{$hotelb->nsingle or ''}}}</td>
              <td>{{{$hotelb->ndouble or ''}}}</td>
              <td>{{{$hotelb->ntwin or ''}}}</td>
              <td>{{{$hotelb->nextra or ''}}}</td>
              <td>{{{$hotelb->nchextra or ''}}}</td>
              <td>{{{$hotelb->net_amount or ''}}}</td>
              <?php $total_no_of_booked_night=$total_no_of_booked_night+ $hotelb->book_day ?>
            </tr>
            @endif
          @endforeach
        @endif
      </tbody>
    </table>
    <h3><strong class="">Total number of booked night : {{$total_no_of_booked_night}}</strong></h3>



  </div>
  	@include('admin.include.datepicker')
@endsection
