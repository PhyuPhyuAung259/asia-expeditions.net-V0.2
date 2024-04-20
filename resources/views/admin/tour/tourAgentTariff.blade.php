@extends('layout.backend')
@section('title','Tour Agent Tariff')
<?php  use App\component\Content;?>
@section('content')

	<div class="container">
    @include('admin.report.headerReport')
		<h3 class="text-right">
			<a class="hidden-print" href="javascript:void(0)" onclick="window.print();"><span class="fa fa-print"></span></a> &nbsp;
		</h3>
        <h3 class="text-center"><strong class="btborder" style="text-transform: uppercase;">Excursion Tariff As of ({{ \Carbon\Carbon::now()->format('Y-m-d') }})</strong></h3>
        @foreach($tours as $tour)
		<div class="modal" id="myModal" role="dialog" data-backdrop="static" data-keyboard="true">
	<div class="modal-dialog modal-lg">
	    <form method="POST" action="{{route('editTourDesc',['tourId'=>$tour->id])}}">
	      <div class="modal-content">       
	        <input type="hidden" name="tour_id" id="tour_id" value="{{$tour->id}}"> 
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title" ><strong id="tour_name">Add Service</strong></h4>
	        </div>
	        <div class="modal-body">
	          {{csrf_field()}} 
	          <div class="row">
	            <div class="col-md-12">
	              <div class="form-group">
	                <label>Tour Descriptions</label>
	                <div id="container" >
                        @include('include.editor')
                        <div class="editor1" style="resize:both; overflow:auto;max-width:100%;min-width: 100%;" class="titletou" contenteditable="true"  data-text="Enter comment....">
                        </div>
                        <textarea class="form-control my-editor" name="tour_desc" id="tour_desc" rows="7" placeholder="Tour Detials" style="display: none;"></textarea>
                    </div> 
	                <!-- script src="{{asset('adminlte/editor/tinymce.min.js')}}"></script>
	               	<textarea class="form-control my-editor" name="tourBook_desc" id="tourBook_desc" rows="7" placeholder="Tour Detials"></textarea -->
	              </div> 
	            </div>
	          </div>
	          <div class="modal-footer" style="text-align: center">
	              <button type="submit" class="btn btn-success btn-flat btn-sm Book_desc">Save</button>
	              <a href="#" class="btn btn-danger btn-flat btn-sm" data-dismiss="modal">Close</a>
	          </div>
	        </div>     
	      </div>   
	    </form>
	</div>
</div>
		<h4><strong>{{$tour->tour_name}}</strong></h4>
		<div><strong>Destination: {{{$tour->province->province_name or ''}}}</strong> <small><span class="fa fa-exchange"></span></small> <strong>{{$tour->tour_dest}}</strong></div>
		
		<table class="table">
			<tbody>
				<!-- <tr>
					<td style="width: 75%; vertical-align: top;" >
						<div><strong>HightLights</strong></div>
						<p>{!! $tour->tour_intro !!}</p>
					</td>
					<td rowspan="3" style="vertical-align: top;">
						<table class="table">
							<tr>
								<th class="text-center" style="border-top: none;">Tour Pax</th>
								<th class="text-center" style="border-top: none;">Tariff Price</th>
							</tr>							
								@foreach($tour->pricetour as $pax_price)
								
										@if($pax_price->sprice > 0 && $pax_price->pax_no < 7)
											<tr>
												<td class="text-center">{{$pax_price->pax_no}}</td>
												<td class="text-center">{{Content::money($pax_price->sprice)}} <span class="pcolor">{{Content::currency()}}</span></td>
											</tr>
										@endif
									
								@endforeach
						</table>
					</td>		
				</tr>	 -->
				@if(!empty($tour->tour_desc))
				<tr>
					<td style="width: 75%; vertical-align: top;" >
						<div><strong>Description</strong></div>
						<p>{!! $tour->tour_desc !!}</p>
						<a class="btn btn-default btn-xs" href="{{route('getTourUpdate', ['url'=> $tour->id])}}" title="Edit Tour" target="_blank">
                        Edit
                      </a>	
					</td>
					<td rowspan="3" style="vertical-align: top;">
						<table class="table">
							<tr>
								<th class="text-center" style="border-top: none;">Tour Pax</th>
								<th class="text-center" style="border-top: none;">Tariff Price</th>
							</tr>							
								@foreach($tour->pricetour as $pax_price)
								
										@if($pax_price->sprice > 0 && $pax_price->pax_no < 7)
											<tr>
												<td class="text-center">{{$pax_price->pax_no}}</td>
												<td class="text-center">{{Content::money($pax_price->sprice)}} <span class="pcolor">{{Content::currency()}}</span></td>
											</tr>
										@endif
									
								@endforeach
						</table>
					</td>	
				</tr>	
				@endif
				@if(!empty($tour->tour_remark))
				<tr>					
					<td style="vertical-align: top;">
						<div><strong>Services Includes/ Excluded : </strong></div>
						<p>{!! $tour->tour_remark !!}</p>
					</td>
				</tr>
				@endif
				@if($tour->tour_feasility->count() > 0)
				<tr>					
					<td style="vertical-align: top;">
						<div><strong>Tour Feasility</strong></div>
						<ul>
							@foreach($tour->tour_feasility as $ts)
							<li>{{$ts->service_name}}</li>
							@endforeach
						</ul>
					</td>
				</tr>
				@endif
				<!-- @if($tour->tour_picture || $tour->tour_photo)
				<tr><td><strong>Galleries</strong></td></tr>
				<tr>
					<?php $photos = explode("|", rtrim($tour->tour_picture,'|')); ?>
					<td>
						<div class="row">
						@if($tour->tour_photo)
						<div class="col-sm-4 col-xs-4" style="padding-right:4px;">
							<div class="form-group">
								<img src="{{Content::urlthumbnail($tour->tour_photo, $tour->user_id)}}" style="width: 100%;" />
							</div>
						</div>
						@endif
						@if($tour->tour_picture != '')
							@foreach($photos as $key => $pic)
								@if($key <= 1)	
									<div class="col-sm-4 col-xs-4" style="padding-right:4px;">
										<div class="form-group">
											<img src="{{Content::urlthumbnail($pic, $tour->user_id)}}" style="width: 100%;" />
										</div>
									</div>
								@endif
							@endforeach
						@endif
						</div>
					</td>
				</tr>
				@endif -->
			</tbody>
		</table>
        @endforeach
  	</div>
@endsection
<script type="text/javascript">
 	$(document).ready(function(){
 		$(document).on("click", ".btnEditTour", function(){
 			
			
 			$('.editor1').html($(this).data('desc'));
 			// tinyMCE.activeEditor.setContent($(this).data('desc'));
 		});
 		$('.Book_desc').on('click',function(){
 			var gettext = $(document).find('.editor1').html();
 			$('#_desc').val(gettext);
 		});
 	});
 </script>
