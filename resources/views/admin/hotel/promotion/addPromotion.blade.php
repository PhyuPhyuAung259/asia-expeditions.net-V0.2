@extends('layout.backend')
@section('title', 'Adding Promotion')
<?php $active = 'hotels/getPromotion'; 
  $subactive ='hotels/getPromotion';
  use App\component\Content;
?>

@section('content')
  @include('admin.include.header')
  @include('admin.include.menuleft')
 
  <div class="content-wrapper">

    <section class="content" > 
				<div class="Promotion" >
					<div class="modal-dialog modal-lg">
						<form method="POST" action="{{route('storePromotion')}}">
						<div class="modal-content">        
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title"><strong id="form_title">Adding Promotion</strong> </h4>
							</div>
							<div class="modal-body">
							{{csrf_field()}}    
                            
								<div class="row">
									<div class="col-md-6 col-xs-12">
										<div class="form-group">
											<label>Start Date <span style="color:#b12f1f;">*</span></label> 
											<input type="date" id="start_date" name="start_date" class="form-control book_date" placeholder="Start Date" value="2024-01-01" required>	
										</div> 
									</div>
                  <div class="col-md-6 col-xs-12">
										<div class="form-group">
											<label>End Date <span style="color:#b12f1f;">*</span></label> 
											<input type="date" id="end_date" name="end_date" class="form-control book_date" placeholder="End Date" value="2024-01-01" required>	
										</div> 
									</div>
									<div class="col-md-6 col-xs-6">
									<div class="form-group">
										<label>Country <span style="color:#b12f1f;">*</span></label> 
										<select class="form-control country" id="country" name="country" required>
											<option value="">--Choose--</option>
										@foreach(App\Country::Where('country_status',1)->orderBy('country_name')->get() as $con)
											<option value="{{$con->id}}">{{$con->country_name}}</option>
										@endforeach
										</select>
									</div> 
									</div>
									<div class="col-md-6 col-xs-6">
									<div class="form-group">
										<label>Hotel</label>
										<select class="form-control transport" name="hotel" id="hotel"  >
										  <option value="0">Choose Hotel</option>
										</select>
									</div>
									</div>
                  <div class="col-md-6 col-xs-6">
									<div class="form-group">
										<label>Promotion Name</label>
                    <input type="text" name="name" id="pname" class="form-control editprice" placeholder="Enter promotion name" >
									</div>
									</div>
                  <div class="col-md-6 col-xs-6">
									<div class="form-group">
										<label>Promotion Rate</label>
                    <input type="text" name="promotion_rate" id="promotion_rate" class="form-control editprice" placeholder="10%" >
									</div>
									</div>
									<div class="col-md-12 col-xs-6">
										<div class="form-group">
											<label>Description</label>
											<textarea class="form-control" rows="7" name="description" placeholder="Type description here..."></textarea>
										</div>
										
									</div>
									
							</div>
							<div class="modal-footer">
							<button type="submit" class="btn btn-success btn-flat btn-sm" >Save</button>
							<a href="#" class="btn btn-danger btn-flat btn-sm" data-dismiss="modal">Close</a>
							</div>
							
						</div>      
						</form>
					</div>
				</div>
      </div>
    </section>
  </div>  
  <script  type="text/javascript">
     $('#country').change(function() {
        var countryId = $(this).val();
          $.ajax({
            url: '/hotels/' + countryId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var hotelSelect = $('#hotel');
                hotelSelect.empty();
                if (response.length === 0) {
                    hotelSelect.append('<option value="0">No hotels available</option>');
                } else {
                  hotelSelect.append('<option value="0">Choose Hotel</option>');
                    $.each(response, function(key, value) {
                        hotelSelect.append('<option value="' + value.id + '">' +
                            value.supplier_name + '</option>');
                    });
                } 
            }
          }); 
        });
  </script>
@include('admin.include.datepicker')
@endsection
