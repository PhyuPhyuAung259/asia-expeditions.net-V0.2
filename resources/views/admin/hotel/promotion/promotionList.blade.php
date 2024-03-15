@extends('layout.backend')
@section('title', 'Promotion')
<?php $active = 'hotels/promotion'; 
  $subactive ='hotels/promotion';
  use App\component\Content;
?>

@section('content')
<div class="wrapper">
  @include('admin.include.header')
  @include('admin.include.menuleft')
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
            @include('admin.include.message')
            <form method="POST" >
                {{csrf_field()}}
                <section class="col-lg-12 connectedSortable">
                    <h3 class="border">Promotion List <span class="fa fa-angle-double-right"></span> <a href="{{route('addPromotion')}}" class="btn btn-default btn-sm" >Add Promotion</a></h3>
                    <!-- @include('admin.project.Search') -->
                    <div class="table-responsive">
                      <table class="datatable table table-hover table-striped">
                        <thead>
                            <tr>                       
                            <th width="75">ID</th>
                            <th width="175px">Start Date<i class="fa fa-long-arrow-right" style="color: #72afd2"></i>End Date</th>
                            <th>Name</th>
                            <th>Hotel</th>
                            <th width="100">Promotion Rate</th>
                            <th>Description</th>
                            <th>Operation</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($promotion as $data)
                          <tr>
                            <td>{{$data->id}}</td>
                            <td>{{$data->start_date}} - {{$data->end_date}}</td>
                            <td>{{$data->name}}</td>
                            <td>@php $supplier=App\Supplier::where(['id'=>$data->hotel_id])->first();
                                @endphp
                            {{$supplier->supplier_name}}</td>
                            <td>{{$data->promotion_rate}}</td>
                            <td>{{$data->description}}</td>
                            <td><a href="{{route('getEditPromotion, ['url'=> $data->id])}}" title="Edit Supplier">
                          <label  class="icon-list ic_book_project"></label>
                        </a> <a href="javascript:void(0)" class="RemoveHotelRate" data-type="promotion" data-id="{{$data->id}}" title="Remove this Flight Number ?">
                          <label class="icon-list ic_remove"></label>
                        </a></td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                </section>
            </form>
            </div>
        </section>
    </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
     $(".datatable").DataTable();
  });
</script> 
@include('admin.include.datepicker')
@endsection
