@extends('layout.main')

@section('title', 'Home')

@section('content')
    <!-- Main content -->
    <section class="content">
    	<div class="col-md-12">
			<div class="box box-info">
	            <div class="box-header with-border">
	              <h3 class="box-title">Create New Variant Color</h3>
	            </div>
	            <!-- /.box-header -->
	            <!-- form start -->
	            @foreach($errors->all() as $message)
		            <div style="margin: 20px 0" class="alert alert-error">
		                {{$message}}
		            </div>
		        @endforeach
	            <form class="form-horizontal" action="{{route("$page.store")}}" method="post" enctype="multipart/form-data">
	            	{{csrf_field()}}
	              <div class="box-body">
	                <div class="form-group">
	                  <label for="name" class="col-sm-3 control-label">Color</label>
	                  <div class="col-sm-8">
	                  	<select name="color_id" class="form-control">
	                  		<option selected disabled>Choose Available Color</option>
	                  		@foreach($color as $key => $val)
	                  		<option @if(old('color_id') == $val->id) selected @endif value="{{$val->id}}">{{$val->name}}</option>
	                  		@endforeach
	                  	</select>
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="name" class="col-sm-3 control-label">Size</label>
	                  <div class="col-sm-8">
	                  	<select name="size_id" class="form-control">
	                  		<option selected disabled>Choose Size</option>
	                  		@foreach($size as $key => $val)
	                  		<option @if(old('size_id') == $val->id) selected @endif value="{{$val->id}}">{{$val->name}}</option>
	                  		@endforeach
	                  	</select>
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="qty" class="col-sm-3 control-label">Quantity</label>
	                  <div class="col-sm-8">
	                    <input type="text" class="form-control" name="qty" value="{{old('qty')}}" id="qty" placeholder="Quantity">
	                  </div>
	                </div>

	              </div>
	              <!-- /.box-body -->
	              <div class="box-footer">
	              	<input type="hidden" name="product_id" value="{{$product->id}}">
	                <button type="submit" class="btn btn-info pull-right">Submit</button>
	              </div>
	              <!-- /.box-footer -->
	            </form>
	          </div>
          </div>
    </section>

@endsection