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
		        {!! session('displayMessage') !!}
	            <form class="form-horizontal" action="{{route("$page.update", ['id' => $row->id])}}" method="post" enctype="multipart/form-data">
	            	{{csrf_field()}}
	            	<div class="box-body">
		                <div class="form-group">
		                  <label for="name" class="col-sm-3 control-label">Name</label>
		                  <div class="col-sm-8">
		                    <input type="text" class="form-control" name="name" value="{{$row->name}}" id="name" placeholder="Name">
		                  </div>
		                </div>

		                <div class="form-group">
		                  <label for="parent_id" class="col-sm-3 control-label">Category</label>
		                  <div class="col-sm-8">
		                  	<select name="category[]" multiple id="category" class="form-control select2">
		                  		@foreach($category as $key => $val)
		                  			<option @if(in_array($val->id, $categoryMap)) selected @endif value="{{$val->id}}">{{$val->name}}</option>
		                  		@endforeach
		                  	</select>
		                  </div>
		                </div>

		                <div class="form-group">
		                  <label for="original_price" class="col-sm-3 control-label">Price</label>
		                  <div class="col-sm-8">
		                    <input type="text" class="form-control" onkeyup="formatAmount($(this))" name="original_price" value="{{moneyFormat($row->original_price, false)}}" id="original_price" placeholder="Price">
		                  </div>
		                </div>

		                <div class="form-group">
		                  <label for="original_price" class="col-sm-3 control-label">Discount Price</label>
		                  <div class="col-sm-8">
		                    <input type="text" class="form-control" onkeyup="formatMoney($(this))" name="discount_price" value="{{moneyFormat($row->discount_price, false)}}" id="discount_price" placeholder="Discount Price">
		                  </div>
		                </div>


		                <div class="form-group">
		                  <label for="weight" class="col-sm-3 control-label">Weight (Kg)</label>
		                  <div class="col-sm-8">
		                    <input type="text" class="form-control" name="weight" value="{{$row->weight}}" id="weight" placeholder="Weight">
		                  </div>
		                </div>

		                <div class="form-group">
		                  <label for="description" class="col-sm-3 control-label">Description</label>
		                  <div class="col-sm-8">
		                  	<textarea class="form-control textarea" name="description">{{$row->description}}</textarea>
		                  </div>
		                </div>

		                <div class="form-group">
		                  <label for="meta_description" class="col-sm-3 control-label">Meta Description</label>
		                  <div class="col-sm-8">
		                  	<textarea name="meta_description" rows="5" class="form-control">{{isset($seo->meta_description) ? $seo->meta_description : null}}</textarea>
		                  </div>
		                </div>

		                <div class="form-group">
		                  <label for="meta_keywords" class="col-sm-3 control-label">Meta Keywords</label>
		                  <div class="col-sm-8">
		                  	<input type="text" class="form-control" name="meta_keywords" value="{{isset($seo->meta_keywords) ? $seo->meta_keywords : null}}" id="meta_keywords" placeholder="Words separated by comma">
		                  </div>
		                </div>

		                <div class="form-group">
		                  <label for="has_variant" class="col-sm-3 control-label">Has Variant</label>
		                  <div class="col-sm-8">
		                  	<div class="col-sm-8">
				               <label class="radio-inline"><input @if($row->has_variant == 0) checked="checked" @endif type="radio" value="0" name="has_variant">No</label>
		                  	   <label class="radio-inline"><input @if($row->has_variant == 1) checked="checked" @endif type="radio" value="1" name="has_variant">Yes</label>
			               </div>
		                  </div>
		                </div>

		                <div class="form-group" id="image-cont" style="display: {{($row->has_variant == 0) ? 'block' : 'none'}}">
			              <label for="image" class="col-sm-3 control-label">Images *Choose Multiple</label>
			              <div class="col-sm-8">
			                <input type="file" name="image[]" multiple>
			                <div style="margin-top: 20px">
			                	@if(isset($images))
					              	@foreach($images as $key => $val)
					              		<div style="float: left;margin-right: 25px">
					              			<a onclick="return confirm('You will delete this image, continue?')" href="{{route('product-manage.delete-image')}}?product_id={{$row->id}}&image_id={{$val->id}}" style="float: right;position: absolute;background-color: red;color: #fff;font-weight: bold;padding: 3px" href="">
					              				<i class="fa fa-times"></i>
					              			</a>
					              			<img style="width: 180px;height: 180px;" src="{{asset('images') . '/product/' . $row->id . '/0/' . $val->url}}" class="img-responsive">
					              		</div>
					              	@endforeach
					            @endif
			                </div>
			              </div>
			            </div>

			            @include('product.product-manage.options')

	              </div>
	              <!-- /.box-body -->
	              <div class="box-footer">
	                <button type="submit" class="btn btn-info pull-right">Submit</button>
	              </div>
	              <!-- /.box-footer -->
	              {{ method_field('PUT') }}
	            </form>
	          </div>
          </div>
    </section>

@endsection