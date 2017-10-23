@extends('layout.main')

@section('title', 'Home')

@section('content')

<section class="content">
	<div class="col-md-12">
		{!! session('displayMessage') !!}
		<div class="box">
            <div class="box-header">
                <a href="{{route($page.'.create')}}?product_id={{$product->id}}" class="btn btn-info">Create Variant Color</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                  <th>Color</th>
                  <th>Image</th>
                  <th>Total Size</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($resultPerColor['data'] as $key => $val)
                <tr id="color-{{$val->color_id}}">
                  <td>{{getFieldOfTable('colors', $val->color_id, 'name')}}</td>
                  <td><img style="height: 150px" src="{{asset('images/product').'/'.$val->product_id.'/'.$val->color_id.'/'.$val->image}}"></td>
                  <td class="total-color">{{count($resultPerColor['total'][$val->color_id])}}</td>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-info">Action</button>
                      <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
                        <li><a style="cursor: pointer;" data-toggle="modal" data-target="#modal-size-add-{{$val->color_id}}">Add New Size</a></li>
                        <li><a style="cursor: pointer;" data-toggle="modal" data-target="#modal-size-view-{{$val->color_id}}">View All Sizes</a></li>
                        <li class="divider"></li>
                        <li><a style="cursor: pointer;" data-toggle="modal" data-target="#modal-image-add-{{$val->color_id}}">Add New Image</a></li>
                        <li><a style="cursor: pointer;" data-toggle="modal" data-target="#modal-image-view-{{$val->color_id}}">View All Images</a></li>
                      </ul>
                    </div>
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
          </div>
	</div>
  @include('product.product-variant.modal.size-view')
  @include('product.product-variant.modal.size-add')
  @include('product.product-variant.modal.image-view')
  @include('product.product-variant.modal.image-add')
</section>

@endsection