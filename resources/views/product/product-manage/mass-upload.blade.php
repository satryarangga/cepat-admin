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
	            	<table class="table table-bordered table-hover table-striped">
	            		<thead>
	            			<tr>
	            				<th>Product Name</th>
	            				<th>Price</th>
	            				<th>Weight</th>
	            				<th>Description</th>
	            			</tr>
	            		</thead>
	            		<tbody>
	            			@foreach($product as $key => $val)
	            			<tr>
	            				<td>{{$val->productname}}</td>
	            				<td>{{moneyFormat($val->price, false)}}</td>
	            				<td>{{$val->weight}} Kg</td>
	            				<td>{{$val->description}}</td>
	            			</tr>
	            			<input type="hidden" name="productname[]" value="{{$val->productname}}">
	            			<input type="hidden" name="price[]" value="{{$val->price}}">
	            			<input type="hidden" name="weight[]" value="{{$val->weight}}">
	            			<input type="hidden" name="description[]" value="{{$val->description}}">
	            			@endforeach
	            		</tbody>
	            	</table>
	            	<button onclick="return confirm('Are you sure?')" class="btn btn-primary" type="submit">Upload Mass Product</button>
	            </form>
	            @endif
	          </div>
          </div>
    </section>

@endsection