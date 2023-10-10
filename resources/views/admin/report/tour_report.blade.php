@extends('layout.backend')
@section('title', 'Tour Report')
<?php
  $active = 'reports'; 
  $subactive = 'tour_report';
  use App\component\Content;

?>
@section('content')
<div class="wrapper">
  @include('admin.include.header')
  @include('admin.include.menuleft')
  <div class="content-wrapper">
    <section class="content"> 
      <div class="row">
        <section class="col-lg-12 connetedSortable">
          <h3 class="border">Tour Report</h3>
          <form method="POST" action="{{route('searchReport')}}">
            {{csrf_field()}}
            <div class="col-sm-8 pull-right">
              <div class="col-md-2">
                
                <input class="form-control input-sm" type="text" id="from_date" name="start_date" placeholder="From Date" value="{{{$startDate or ''}}}"> 
              </div>
              <div class="col-md-2" style="padding-right: 0px;">
                <input class="form-control input-sm" type="text" id="to_date" name="end_date" placeholder="To Date" value="{{{$endDate or ''}}}"> 
              </div>
                        
              <div class="col-md-2" style="padding-right: 0px;">
                <select class="form-control input-sm" name="location">
                  <option value="0">Location</option>
                  @foreach(App\Country::where('country_status',1)->get() as $country)
                  <option value="{{$country->id}}">{{$country->country_name}}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-2" style="padding-right: 0px;">
                <select class="form-control input-sm" name="type">
                    <option value="0">Report Type</option>
                    <option value="1">Tour</option>
                    <option value="2">Golf</option>
                    <option value="3">Hotel</option>
                </select>
              </div>
              <div class="col-md-2 ml-5" style="padding: 0px;margin-left:10px;">
                <button class="btn btn-primary btn-sm" type="submit">Search</button>
              </div>          
            </div>
        
            <table class="datatable table table-hover table-striped">
              <thead>
                <tr>
                  <th width="280px">Tour Name</th>
                  <th>Country</th>
                  <th>City</th>
                  <th>Tour Type</th>
                  <th>No of Tour</th>
                 
                </tr>
              </thead>
              <tbody>
               @if(!empty($tours))
                @foreach($tours as $tour)
                  
                  <tr>
                    <td>{{$tour->tour_name}}</td>
                    <td><?php  $country = DB::table('country')->where('id', $tour->country_id)->first();?> {{{$country->country_name or ''}}} </td> 
                    <td> <?php  $province = DB::table('province')->where('id', $tour->province_id)->first();?> {{{$province->province_name or ''}}} </td>
                    <td><?php  $type = DB::table('business')->where('id', $tour->tour_type)->first();?> {{{$type->name or ''}}}</td>
                    <td>{{$tour->tour_count}}</td>                  
                  </tr>
                @endforeach
                @endif
              </tbody>
            </table>
          </form>
        </section>
      </div>
    </section>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $(".datatable").DataTable({
      language: {
        searchPlaceholder: "Number No., File No.",
      },
       order: [[4, 'desc']]
    });
  });
</script>
@include('admin.include.datepicker')
@endsection
