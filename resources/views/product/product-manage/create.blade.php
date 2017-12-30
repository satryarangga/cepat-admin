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
	                  <label for="parent_id" class="col-sm-3 control-label">Category</label>
	                  <div class="col-sm-8">
	                  	<select name="category[]" id="category" multiple class="form-control select2">
	                  		@foreach($category as $key => $val)
	                  			<option @if(is_array(old('category')) && in_array($val->id, old('category'))) selected @endif value="{{$val->id}}">{{$val->name}}</option>
	                  		@endforeach
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

	                <div class="form-group">
	                  <label for="meta_description" class="col-sm-3 control-label">Meta Description</label>
	                  <div class="col-sm-8">
	                  	<textarea name="meta_description" rows="5" class="form-control">{{old('meta_description')}}</textarea>
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="meta_keywords" class="col-sm-3 control-label">Meta Keywords</label>
	                  <div class="col-sm-8">
	                  	<input type="text" class="form-control" name="meta_keywords" value="{{old('meta_keywords')}}" id="meta_keywords" placeholder="Words separated by comma">
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="has_variant" class="col-sm-3 control-label">Has Variant</label>
	                  <div class="col-sm-8">
	                  	<div class="col-sm-8">
			               <label class="radio-inline"><input @if(old('has_variant') == 0) checked="checked" @endif type="radio" value="0" name="has_variant">No</label>
	                  	   <label class="radio-inline"><input @if(old('has_variant') == 1) checked="checked" @endif type="radio" value="1" name="has_variant">Yes</label>
		               </div>
	                  </div>
	                </div>

	                <div class="form-group" id="image-cont" style="display: block;">
		              <label for="image" class="col-sm-3 control-label">Images *Choose Multiple</label>
		              <div class="col-sm-8">
		                <input type="file" name="image[]" multiple>
		              </div>
		            </div>

		            @include('product.product-manage.options')

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