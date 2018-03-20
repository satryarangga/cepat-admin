@extends('layout.main')

@section('title', 'Home')

@section('content')
    <!-- Main content -->
    <section class="content">
    	<div class="col-md-12">
			<div class="box box-info">
	            <div class="box-header with-border">
	              <h3 class="box-title">{{ucwords(str_replace('-',' ', $page))}} Product</h3>
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
		              <label for="csv" class="col-sm-3 control-label">Product with variant</label>
		              <div class="col-sm-8">
		              	<label class="radio-inline"><input type="radio" @if(isset($isVariant) && $isVariant == '1')) checked @endif value="1" name="variant">Yes</label>
		              	<label class="radio-inline"><input type="radio" @if(isset($isVariant) && $isVariant == '0')) checked @endif value="0" name="variant">No</label>
		              </div>
		            </div>
		            <div class="form-group">
		              <label for="csv" class="col-sm-3 control-label">CSV File</label>
		              <div class="col-sm-8">
		                <input type="file" name="csv">
		              </div>
		            </div>
	              </div>
	              <!-- /.box-body --> 
	              <div class="box-footer">
	                <button type="submit" class="btn btn-info pull-right">Submit</button>
	              </div>
	              <!-- /.box-footer -->
	            </form>
	            @if(isset($product))
	            <h3>Review Product Inserted</h3>
	            <form method="post" action="{{route("$page.confirm")}}">
	            	{{csrf_field()}}
	            	@if($isVariant == '0')
	            	@include('product.product-manage.mass-upload-no-variant')
	            	@else
	            	@include('product.product-manage.mass-upload-with-variant')
	            	@endif
	            	<input type="hidden" name="is_variant" value="{{$isVariant}}">
	            	<button onclick="return confirm('Are you sure?')" class="btn btn-primary" type="submit">Upload Mass Product</button>
	            </form>
	            @endif
	          </div>
          </div>
    </section>

@endsection