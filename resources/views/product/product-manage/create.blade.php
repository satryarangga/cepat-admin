@extends('layout.main')

@section('title', 'Home')

@section('content')
    <!-- Main content -->
    <section class="content">
    	<div class="col-md-12">
			<div class="box box-info">
	            <div class="box-header with-border">
	              <h3 class="box-title">Create New {{ucwords(str_replace('-',' ', $page))}}</h3>
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
	                  <label for="name" class="col-sm-3 control-label">Name</label>
	                  <div class="col-sm-8">
	                    <input type="text" class="form-control" name="name" value="{{old('name')}}" id="name" placeholder="Name">
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="parent_id" class="col-sm-3 control-label">Category Parent</label>
	                  <div class="col-sm-8">
	                  	<select name="cat_parent_id" id="cat_parent_id" class="form-control">
	                  		<option disabled selected>Select Category Parent</option>
	                  		@foreach($categoryParent as $key => $val)
	                  			<option @if(old('parent_id') == $val->id) selected @endif value="{{$val->id}}">{{$val->name}}</option>
	                  		@endforeach
	                  	</select>
	                  </div>
	                </div>

	                <div class="form-group" style="display: none;" id="cat_child_container">
	                  <label for="parent_id" class="col-sm-3 control-label">Category Child</label>
	                  <div class="col-sm-8">
	                  	<select name="cat_child_id" id="cat_child_id" class="form-control">
	                  	</select>
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="original_price" class="col-sm-3 control-label">Price</label>
	                  <div class="col-sm-8">
	                    <input type="text" class="form-control" onkeyup="formatMoney($(this))" name="original_price" value="{{old('original_price')}}" id="original_price" placeholder="Price">
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="weight" class="col-sm-3 control-label">Weight (Kg)</label>
	                  <div class="col-sm-8">
	                    <input type="text" class="form-control" name="weight" value="{{old('weight')}}" id="weight" placeholder="Weight">
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="description" class="col-sm-3 control-label">Description</label>
	                  <div class="col-sm-8">
	                  	<textarea name="description" class="form-control textarea">{{old('description')}}</textarea>
	                  </div>
	                </div>

	              </div>
	              <!-- /.box-body -->
	              <div class="box-footer">
	                <button type="submit" class="btn btn-info pull-right">Submit</button>
	              </div>
	              <!-- /.box-footer -->
	            </form>
	          </div>
          </div>
    </section>

@endsection