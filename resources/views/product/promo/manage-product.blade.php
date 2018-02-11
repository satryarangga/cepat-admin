@extends('layout.main')

@section('title', 'Home')

@section('content')

<section class="content">
  <div class="col-md-12">
    {!! session('displayMessage') !!}
    <div class="box">
            <div class="box-header">
                <a data-toggle="modal" data-target="#modal-add-product" class="btn btn-info">Add New Product</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Original Price</th>
                  <th>Promo Price</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($result as $key => $val)
                <tr>
                <td>{{$val->name}}</td>
                <td>{{moneyFormat($val->original_price)}}</td>
                <td>{{moneyFormat($val->promo_price)}}</td>
                </td>
                <td>
                  <div class="btn-group">
                    <button type="button" class="btn btn-info">Action</button>
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                      <li><a style="cursor: pointer;" data-toggle="modal" data-target="#modal-edit-product-{{$val->id}}">Edit</a></li>
                        <li><a onclick="return confirm('You will remove this product from promo, continue?')" href="{{route('promo.delete-product', ['id' => $val->id])}}">Delete</a></li>
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
  @include('product.promo.modal.modal-add-product')
  @include('product.promo.modal.modal-edit-product')
</section>

@endsection