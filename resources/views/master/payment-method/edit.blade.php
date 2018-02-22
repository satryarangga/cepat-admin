@extends('layout.main')

@section('title', 'Home')

@section('content')
    <!-- Main content -->
    <section class="content">
    	<div class="col-md-12">
			<div class="box box-info">
	            <div class="box-header with-border">
	              <h3 class="box-title">Edit {{ucwords(str_replace('-',' ', $page))}}</h3>
	            </div>
	            <!-- /.box-header -->
	            <!-- form start -->
	            @foreach($errors->all() as $message)
		            <div style="margin: 20px 0" class="alert alert-error">
		                {{$message}}
		            </div>
		        @endforeach
	            <form class="form-horizontal" action="{{route("$page.update", ['id' => $row->id])}}" method="post" enctype="multipart/form-data">
	            	{{csrf_field()}}
	              <div class="box-body">
	                <div class="form-group">
	                  <label for="name" class="col-sm-2 control-label">Payment Name</label>
	                  <div class="col-sm-10">
	                    <input type="text" class="form-control" name="name" value="{{$row->name}}" id="name" placeholder="Payment Name">
	                  </div>
	                </div>
	                
	                <div class="form-group">
	                  <label for="desc" class="col-sm-2 control-label">Payment Description</label>
	                  <div class="col-sm-10">
	                  	<textarea name="desc" rows="5" class="form-control">{{$row->desc}}</textarea>
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="logo" class="col-sm-2 control-label">Logo</label>
	                  <img src="{{asset('images/payment-method/'.$row->logo)}}" style="width: 50; height: 25px" />
	                  <div class="col-sm-10">
	                  	<input type="file" name="logo">
	                  </div>
	                </div>

	                <div class="form-group">
			            <label for="discount_type" class="col-sm-2 control-label">Confirmation Type</label>
			            <div class="col-sm-10">
				            <label class="radio-inline">
				            	<input @if($row->confirm_type == 1) checked="checked" @endif type="radio" value="1" name="confirm_type">Manual
				            </label>
				            <label class="radio-inline">
				            	<input @if($row->confirm_type == 2) checked="checked" @endif type="radio" value="2" name="confirm_type">Automatic
				            </label>
			               </div>
			         </div>

			         <div class="form-group">
			            <label for="use_paycode" class="col-sm-2 control-label">Use Paycode</label>
			            <div class="col-sm-10">
				            <label class="radio-inline">
				            	<input @if($row->use_paycode == 0) checked="checked" @endif type="radio" value="0" name="use_paycode">No
				            </label>
				            <label class="radio-inline">
				            	<input @if($row->use_paycode == 1) checked="checked" @endif type="radio" value="1" name="use_paycode">Yes
				            </label>
			               </div>
			         </div>

			         <div class="form-group">
	                  <label for="name" class="col-sm-2 control-label">Minimum Payment</label>
	                  <div class="col-sm-10">
	                    <input type="number" class="form-control" name="minimum_payment" value="{{$row->minimum_payment}}" id="minimum_payment" placeholder="Leave blank if no minimum payment">
	                  </div>
	                </div>

	              </div>
	              <!-- /.box-body -->
	              
	              <!-- /.box-footer -->
	              {{ method_field('PUT') }}
		            <!-- /.tab-content -->
		            <div class="box-footer">
	                	<button type="submit" class="btn btn-info">Submit</button>
	              	</div>
	            </form>
	          </div>
          </div>

    </section>

@endsection