@extends('layout.backend')
@section('title', 'Client Arrival Report')
<?php
  $active = 'reports'; 
  $subactive = 'project/operation-daily-chart';
  use App\component\Content;
  $agent_id = isset($agentid) ? $agentid:0;
  $locat = isset($location) ? $location:0;
  $main = isset($sort_main) ? $sort_main:0;
?>
@section('content')
<div class="wrapper">
  @include('admin.include.header')
  @include('admin.include.menuleft')
  <div class="content-wrapper">
    <section class="content"> 
      <div class="row">
        <section class="col-lg-12 connectedSortable">
          <h3 class="border">Operation Daily Chart</h3>
          <form method="POST" action="{{route('searchPOSDailyChart')}}">
            {{csrf_field()}}
            <div class="col-sm-8 pull-right">
              <div class="col-md-2">
                <input type="hidden" name="" value="{{{$projectNo or ''}}}" id="projectNum">
                <input readonly class="form-control input-sm" type="text" id="from_date" name="start_date" placeholder="From Date" value="{{{$startDate or ''}}}"> 
              </div>
              <div class="col-md-2" style="padding-right: 0px;">
                <input readonly class="form-control input-sm" type="text" id="to_date" name="end_date" placeholder="To Date" value="{{{$endDate or ''}}}"> 
              </div>
              <div class="col-md-2">
                <select class="form-control input-sm" name="sort_location">
                  @foreach(\App\Country::countryByProject() as $con)
                    <option value="{{$con->id}}" {{isset($country) && $con->id == $country ? 'selected' : ''}}>{{$con->country_name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-2" style="padding: 0px;">
                <button class="btn btn-primary btn-sm" type="submit">Search</button>
              </div>   
              <div class="col-md-4 text-right" >
                 <!-- <button class="btn btn-primary btn-sm" type="submit">Search</button> -->
                <span class="btn btn-primary btn-sm myConvert"> <i class="fa fa-download"></i>Download</span>
              </div>
            </div>
          <table class="datatable table table-hover table-striped">
            <thead>
              <tr>
                <th style="width:50px;">Date</th>
                <th style="width: 18px;">FileNo.</th>
                <th style="width: 250px;">Client Name</th>
                <th >City / Tour Name</th>
                <th width="170px">Tour Start->End Date</th>
                <th>Guide Name / Phone</th>
                <th>Driver Name/ Phone</th>
                <th>City/Hotel</th>
                <th>City/Golf</th>
                <th>Restaurant</th>
                <!-- <th style="width: 60px;">Status</th> -->
              </tr>
            </thead>
             
          </table>
        </form>
        </section>
      </div>
    </section>
  </div>
</div>
<script type="text/javascript" src="{{asset('js/jquery.table2excel.min.js')}}"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $(".datatable").DataTable({
      // language: {
      //   searchPlaceholder: "Number No., File No.",
      // }
      columnDefs: [
        {  type : "datetime-moment", targets:  "sort-date" },
     ]
    });

    $(".myConvert").click(function(){
        if(confirm('Do you to export in excel?')){
          $(".datatable").table2excel({
            exclude: ".noExl",
            name: "Daily Operation Chart {{{ $startDate or ''}}} - {{{ $endDate or ''}}}",
            filename: "Daily Operation Chart {{{ $startDate or ''}}} - {{{ $endDate or ''}}}",
            fileext: ".xls",
            exclude_img: true,
            exclude_links: true,
            exclude_inputs: true
            
          });
          return false;
        }else{
          return false;
        }
      });
  });
</script>
@include('admin.include.datepicker')
@endsection
