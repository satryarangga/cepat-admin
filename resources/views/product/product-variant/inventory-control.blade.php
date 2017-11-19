@extends('layout.main')

@section('title', 'Home')

@section('content')

<section class="content">
	<div class="col-md-12">
		{!! session('displayMessage') !!}
		<div class="box">
            <div class="box-header">
              <form class="form-inline">
                <div class="form-group">
                  <label class="control-label">Search by</label>
                  <select name="search_by" class="form-control">
                    <option @if($filter['search_by'] == 'sku') selected @endif value="sku">SKU</option>
                    <option @if($filter['search_by'] == 'product_name') selected @endif value="product_name">Product Name</option>
                  </select>
                </div>
                <div class="form-group" style="margin-left: 10px">
                  <label class="control-label">Keyword</label>
                  <input type="text" name="keyword" value="{{$filter['keyword']}}" class="form-control" />
                </div>
                <div class="form-group" style="margin-left: 10px">
                  <input type="submit" value="Search" class="btn btn-primary">
                </div>
              </form>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                  <th>SKU</th>
                  <th>Product Name</th>
                  <th>Color</th>
                  <th>Size</th>
                  <th>Qty Order</th>
                  <th>Qty Warehouse</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $key => $val)
                <tr>
                  <td>{{$val->SKU}}</td>
                  <td>{{$val->product_name}}</td>
                  <td>{{$val->color_name}}</td>
                  <td>{{$val->size_name}}</td>
                  <td>{{$val->qty_order}}</td>
                  <td>{{$val->qty_warehouse}}</td>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-info">Action</button>
                      <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
                        <li><a data-toggle="modal" data-target="#modal-change-inventory-{{$val->SKU}}" style="cursor: pointer;">Change Inventory</a></li>
                        <li><a data-toggle="modal" data-target="#modal-inventory-log-{{$val->SKU}}" style="cursor: pointer;">View Inventory Logs</a></li>
                      </ul>
                    </div>
                  </td>
                </tr>
                @endforeach
              </table>
              {{$list->links()}}
            </div>
            <!-- /.box-body -->
          </div>
	</div>
  @include('product.product-variant.modal.inventory-change')
  @include('product.product-variant.modal.inventory-log')
</section>

@endsection