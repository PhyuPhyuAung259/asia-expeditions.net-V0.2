@extends('layout.backend')
@section('title', 'P & L')
<?php 
	use App\component\Content;
	$comadd = \App\Company::find(1);
	$amount = "Amount";
	$invoice = "Invoice";
?>
@section('content')
<div class="container-fluid">
	@include('admin.report.headerReport')		
	<div class="col-md-12 text-center">
		<div class="row">
			<h4 ><strong style="font-size: 16px; text-transform:capitalize;">P&L By Projects {{Content::dateformat($start_date) }} to {{ Content::dateformat($end_date) }}</strong></h4>	
		</div>
	</div>
	<div class="col-md-8 col-md-offset-2 hidden-print" style="background-color: #e8f1ff;border: 1px solid #c1c1c1;padding-top: 15px;border-radius: 5px;">
	    <form method="GET" action="" class="form-group">      
	        @if(\Auth::user()->role_id == 2)
		        <div class="col-md-2 col-sm-2 col-lg-2 col-xs-6">
		          	<div class="form-group">
			            <select class="form-control country_book_supplier" name="country" data-type="supplier_book">
			              <option value="">Location</option>
			              @foreach(App\Country::LocalPayment() as $con)
			                <option value="{{$con->id}}" {{$conId == $con->id ? 'selected' : '' }}>{{$con->country_name}}</option>
			              @endforeach
			            </select>
		            </div>
		        </div>
	        @endif
         	<div class="col-md-2 col-sm-2 col-lg-2 col-xs-6">
	          	<div class="form-group">
		            <input class="form-control" name="projectNum" value="{{{$projectNum or ''}}}" placeholder="File Number: 2236">
	            </div>
	        </div>
	        <div class="col-md-7 col-sm-7 col-lg-7 col-xs-9">
	        	<div class="form-group ">
		          	<div class="input-group">
			  			<input type="text" name="start_date" class="form-control text-center" id="from_date" value="{{{$start_date or '' }}}" readonly>
					  	<span class="input-group-addon" id="basic-addon3">From To </span>
					  	<input type="text" name="end_date" class="form-control text-center" id="to_date" value="{{{$end_date or ''}}}" readonly>
					</div>
				</div>
	        </div>
	        <div class="col-md-1 col-sm-1 col-lg-1 col-xs-1">
	        	<div class="form-group">
		          	<button type="submit" class="btn btn-primary">Search</button>
		        </div>
	        </div>           
	    </form>
	    <div class="clearfix"></div>
	</div>
	<div class="clearfix"></div>
	@if($getGrossProfite->count() > 0)
	<div class="pull-right hidden-print">
	   	<a href="javascript:void(0)" class="myConvert hidden-print"><span class=" btn btn-primary btn-acc btn-xs"><i class="fa fa-download"></i> Download In Excel</span></a>&nbsp;
	    <span onclick="window.print()" class="hidden-print btn btn-xs btn-primary btn-acc"><i class="fa fa-print"></i> Print</span>
	</div>
	@endif
	<form target="_blank" action="{{route('getProfitAndLoss')}}">
		<input type="hidden" name="end_date"  value="{{{$end_date or ''}}}">
		<input type="hidden" name="start_date"  value="{{{$start_date or ''}}}">
	    <div class="pull-left">
	        <button type="submit" class="btn btn-default btn-acc btn-xs hidden-print btnPreview" disabled=""><i class="fa fa-eye"></i> Preview</button>
	    </div>
	    <div class="clearfix"></div><br>
		<table class="table tableExcel" border="1">
		  	<tr style="background: #3c8dbc0a;">
		  		<th width="55px"><input name="checkbox" style="font-size: 13px;position: relative;top: 4px;width: 14px;height: 14px;" type="checkbox" id="check_all" > No.</th>
		  		<th width="160px">Travelling Date</th>
		  		<th>File No.</th>
		  		<th>Clients Name</th>
		  		<th>Agent Name</th>
		  		<th class="text-right">Revenue</th>
		  		<th class="text-right">Received</th>
		  		<th class="text-right">Balance To Receive</th>
		  		<th class="text-right">Cost Of Sales</th>
		  		<th class="text-right">Paid Amount</th>
		  		<th class="text-right">Balance To Pay</th>
		  		<th class="text-right">Gross Profit</th>
		  		<th class="text-right">Net Profit</th>
		  		<th class="text-right">Action</th>
		  	</tr>
		  	<tbody>
		  		<?php $n =0; ?>
		  		<?php $plTotalRVED = 0; $plTotalCostOfSales= 0; $plTotalGrossProfit= 0; $plTotalNetProfit=0;?>
		  		@foreach($getGrossProfite as $key => $acc )		  		
			  		<?php
			  			$n++;
			  			$getJournalRP = App\AccountTransaction::where(['project_id'=>$acc->project_id, 'status'=>1])->whereNotNull('project_id');
			  			$supplier = App\Supplier::find($acc->project['supplier_id']);		
			  			$project  = App\Project::find($acc->project_id);

			  			$hotelBook  = App\HotelBooked::where('project_number', $acc->project['project_number']);
						$cruiseBook = App\CruiseBooked::where('project_number', $acc->project['project_number']);
						$tourBook   = App\Booking::tourBook($acc->project['project_number']);
						$flightBook = App\Booking::flightBook($acc->project['project_number']);
						$golfBook   = App\Booking::golfBook($acc->project['project_number']);
						$getRevenue = App\AccountJournal::where(['project_id'=>$acc->project['id'] , 'status'=>1, 'account_type_id'=>8, 'type'=>2])->whereNotNull('project_id');
						$costofSales = App\AccountJournal::where(['project_id'=>$acc->project['id'] , 'status'=>1, 'type'=>1])->whereNotIn('account_type_id', [8])->whereNotNull('project_id');
						$totalRevenue = ($getRevenue->sum('credit') );
						$totalCostSales = $costofSales->sum('debit');
			  		?>
			  		<tr>
			  			<?php 			  			
				  			$totalRecieved = 0;
			  				$totalPaid= 0;
				  			foreach ($getJournalRP->get() as $key => $accjourn) {	
								$accTransactionRP = App\AccountTransaction::where(["project_id"=>$acc['project_id'], 'entry_code'=>$accjourn->entry_code, 'status'=>1, 'account_type_id'=>8, 'type'=> $accjourn->type]);
				  				
				  				$exRate = $accTransactionRP->sum('ex_rate');
				  				$debitKyat = $accTransactionRP->sum("kdebit") / ($exRate > 0 ? $exRate : 1);
				  				$totalRecieved = $totalRecieved + $accTransactionRP->sum('debit') + $debitKyat;

				  				$accTransactionAP = App\AccountTransaction::where(["project_id"=>$acc['project_id'], 'journal_id'=>$accjourn->journal_id, 'status'=>1, 'type'=>$accjourn->type])->whereNotIn('account_type_id', [8]);
				  				$exRateRP = $accTransactionAP->sum('ex_rate');
				  				$creditKyat = $accTransactionAP->sum('kcredit') / ($exRateRP > 0 ? $exRateRP : 1);
				  				$totalPaid = $totalPaid + $accTransactionAP->sum('credit') + $creditKyat;
				  			}
			  			?>
			  			<td><input style="position: relative;top: 4px; width: 14px;height: 14px;" type="checkbox" name="journCheck[]" value="{{$acc->id}}" class="checkall"> {{$n}}</td>
				  		<td>{{Content::dateformat($acc->project['project_start'])}} -> {{Content::dateformat($acc->project['project_end'])}} </td>
			  			<td title="Posting Preview Details"><a target="_blank" href="{{route('getJournalReport', ['journal_entry'=>$acc->project['project_number']])}}">{{ $acc->project['project_prefix']}}-{{$acc->project['project_fileno']}}</a></td>
			  			<?php 
			  				$plTotalRVED = $plTotalRVED + $totalRecieved;
			  				$plTotalCostOfSales = $plTotalCostOfSales + ($totalPaid > 0 ? $totalPaid : 0);
			  				$grossMoney = ($totalRevenue - $totalCostSales);
			  				$plTotalGrossProfit = $plTotalGrossProfit + ($grossMoney > 0 ? $grossMoney : 0);

			  				$netProfit = ($totalRecieved - $totalCostSales);
			  				$grossProfit = ($totalRevenue - $totalCostSales);
			  			 ?>
			  			<td>{{ $acc->project['project_client'] }}</td>
			  			<td>{{ $supplier['supplier_name']}}</td>
			  			<td class="text-right">{{Content::money( $totalRevenue)}}</td>
			  			<td class="text-right" style="color: #3c8dbc;"><b>{{Content::money($totalRecieved)}}</b></td>
			  			<td class="text-right">{{Content::money( $totalRevenue - $totalRecieved )}} </td>
			  			<td class="text-right">{{Content::money($totalCostSales)}}</td>
			  			<td class="text-right" style="color: #3c8dbc;"><b>{{Content::money($totalPaid)}}</b></td>
			  			<td class="text-right">{{Content::money($totalCostSales - $totalPaid)}}</td>
			  			<td class="text-right"​​ style="color: {{$grossProfit <= 0 ? 'red': '#3c8dbc'}};"><b>{{number_format($grossProfit,2)}}</b></td>
			  			<td class="text-right" style="color: {{$netProfit <= 0 ? 'red': '#3c8dbc'}};"><b>{{number_format($netProfit,2)}}</b></td>

			  			<td class="text-right"> 
			  				<a target="_blank" href="{{route('pnlbysegment', ['preview_segment'=>$project->project_number,
                           'start_date'=>$start_date, 'end_date'=>$end_date ])}}" title="Preview Profit and Loss With Segments">
                            <label style="cursor:pointer;" class="icon-list ic_inclusion"></label>
                          </a></td>
			  			<?php $plTotalNetProfit = $plTotalNetProfit + ($netProfit > 0 ? $netProfit : 0); ?>
			  		</tr>
		  		@endforeach
		  		<tr style="background-color: #e8f1ff;">
		  			<th colspan="6" class="text-right">Sub Total:</th>
		  			<th class="text-right">{{number_format($plTotalRVED,2)}} {{Content::currency()}}</th>
		  			<th></th>
		  			<th></th>
		  			<th class="text-right">{{number_format($plTotalCostOfSales,2)}} {{Content::currency()}}</th>
		  			<th></th>
		  			<th class="text-right" style="color: {{$plTotalGrossProfit <= 0 ? 'red':'' }}">{{number_format($plTotalGrossProfit, 2)}} {{Content::currency()}}</th>
		  			<th class="text-right" style="color: {{$plTotalNetProfit <= 0 ? 'red':'' }} ">{{number_format($plTotalNetProfit, 2)}} {{Content::currency()}}</th>
		  			<th></th>
		  		</tr>
		  	</tbody>
		</table>
	</form>
</div>
<script type="text/javascript">
  $(document).ready(function(){
      $(".myConvert").click(function(){
          if(confirm('Do you to export in excel?')){
            $(".tableExcel").table2excel({
              exclude: ".noExl",
              name: "Profit & Loss",
              filename: "Daily Cash Between {{Content::dateformat($start_date)}} And {{Content::dateformat($end_date)}} ",
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
<script type="text/javascript" src="{{asset('js/jquery.table2excel.min.js')}}"></script>

@include('admin.include.datepicker')
@endsection
