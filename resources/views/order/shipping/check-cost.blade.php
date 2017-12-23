@extends('layout.main')

@section('title', 'Home')

@section('content')
    <!-- Main content -->
    <section class="content">
    	<div class="col-md-12">
			<div class="box box-info">
	            <div class="box-header with-border">
	              <h3 class="box-title">Check Shipping Cost</h3>
	            </div>
	            <!-- /.box-header -->
	            <!-- form start -->
	            @foreach($errors->all() as $message)
		            <div style="margin: 20px 0" class="alert alert-error">
		                {{$message}}
		            </div>
		        @endforeach
	            <form class="form-horizontal" method="get" enctype="multipart/form-data">
	              <div class="box-body">
	                <div class="form-group">
	                  <label for="province" class="col-sm-2 control-label">Sender Province</label>
	                  <div class="col-sm-10">
	                  	<input type="text" class="form-control" name="sender_province_name" value="{{$sender_province_name}}" id="sender_province" placeholder="Sender Province">
	                  	<input type="hidden" name="sender_province_id" id="sender_province_id" value="{{$sender_province_id}}">
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="sender_city" class="col-sm-2 control-label">Sender City</label>
	                  <div class="col-sm-10">
	                  	<select class="form-control" id="sender_city_id" name="sender_city_id">
	                  		<option>Choose Sender City</option>
	                  	</select>
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="province" class="col-sm-2 control-label">Receiver Province</label>
	                  <div class="col-sm-10">
	                  	<input type="text" class="form-control" name="receiver_province_name" value="{{$receiver_province_name}}" id="receiver_province" placeholder="Receiver Province">
	                  	<input type="hidden" name="receiver_province_id" id="receiver_province_id" value="{{$receiver_province_id}}">
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="receiver_city" class="col-sm-2 control-label">Receiver City</label>
	                  <div class="col-sm-10">
	                  	<select class="form-control" id="receiver_city_id" name="receiver_city_id">
	                  		<option>Choose Receiver City</option>
	                  	</select>
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="province" class="col-sm-2 control-label">Weight *in gram</label>
	                  <div class="col-sm-10">
	                  	<input type="number" value="{{$weight}}" name="weight" class="form-control">
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="province" class="col-sm-2 control-label">Select Courier</label>
	                  <div class="col-sm-10">
	                  	@foreach($courier as $key => $val)
	                  	<label class="checkbox-inline">
	                  		<input @if(in_array($key, $selectedCourier)) checked @endif name="courier[]" type="checkbox" value="{{$key}}">{{$val}}
	                  	</label>
	                  	@endforeach
	                  </div>
	                </div>


	              </div>
	              <!-- /.box-body -->
	              <div class="box-footer">
	                <button type="submit" class="btn btn-info pull-right">Check Shipping Cost</button>
	              </div>
	              <!-- /.box-footer -->
	            </form>
	          </div>
	          @if($cost)
	          @foreach($cost as $key => $val)
	          <div class="box box-info">
	          	<div class="box-header with-border">
	              <h3 class="box-title">{{$val['name']}}</h3>
	            </div>
	          	<div class="box-body">
	            	<table class="table table-bordered table-hover table-striped">
	            		<thead>
                			<tr>
                				<th>Service</th>
                				<th>Description</th>
                				<th>Estimated Delivery Time</th>
                				<th>Price</th>
                			</tr>
                		</thead>
                		<tbody>
                			@foreach($val['costs'] as $keyCost => $valCost)
                			<tr>
                				<td>{{$valCost['service']}}</td>
                				<td>{{$valCost['description']}}</td>
                				<td>{{$valCost['cost'][0]['etd']}}</td>
                				<td>{{moneyFormat($valCost['cost'][0]['value'])}}</td>
                			</tr>
                			@endforeach
                		</tbody>
	            	</table>
	            </div>
	          </div>
	          @endforeach
	          @endif
          </div>
    </section>

@endsection