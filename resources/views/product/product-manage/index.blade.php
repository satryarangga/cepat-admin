@extends('layout.main')

@section('title', 'Home')

@section('content')

<section class="content">
	<div class="col-md-12">
		{!! session('displayMessage') !!}
		<div class="box">
            <div class="box-header">
                <form style="float: right;" class="form-inline">
                  <div class="form-group">
                    <label class="control-label">Search by</label>
                    <select name="search_by" class="form-control">
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
                <a style="float: left;" href="{{route($page.'.create')}}" class="btn btn-info">Create Product</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Price</th>
                  <th>Weight</th>
                  <th>Status</th>
                  <th>Countdown</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($result as $key => $val)
                <tr>
                <td>{{$val->name}}</td>
                <td>{{moneyFormat($val->original_price)}}</td>
                <td>{{$val->weight}} Kg</td>
                <td>{!!setActivationStatus($val->status)!!}</td>
                <td id="countdown-{{$val->id}}"></td>
                <td>
                	<div class="btn-group">
	                  <button type="button" class="btn btn-info">Action</button>
	                  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
	                    <span class="caret"></span>
	                    <span class="sr-only">Toggle Dropdown</span>
	                  </button>
	                  <ul class="dropdown-menu" role="menu">
    	                <li><a href="{{ route($page.'.edit', ['id' => $val->id]) }}">Edit</a></li>
                      <li><a href="{{ route('product-variant'.'.index') }}?product_id={{$val->id}}">View Variant</a></li>
  	                  <li class="divider"></li>
                      @if($val->status == 1)
                        <li><a href="{{ route($page.'.change-status', ['id' => $val->id, 'status' => 0]) }}">Set Not Active</a></li>
                        @else
                        <li><a href="{{ route($page.'.change-status', ['id' => $val->id, 'status' => 1]) }}">Set Active</a></li>
                      @endif
    	                <li>
    	                  <form class="deleteForm" method="post" action="{{route("$page.destroy", ['id' => $val->id])}}">
    	                    {{csrf_field()}}
    	                    <button onclick="return confirm('You will delete product {{$val->name}} and all of its variants, continue?')" type="submit">Delete</button>
    	                    {{ method_field('DELETE') }}
    	                  </form>
    	                </li>
                      <li class="divider"></li>
                      @if($val->duration)
                        <li><a 
                          onclick="return confirm('You will stop countdown timer for {{$val->name}}, continue?')" href="{{route('product-manage.stopCountdown', ['id' => $val->countdown_id, 'name' => $val->name])}}">Stop Countdown</a></li>
                      @else
                        <li><a style="cursor: pointer;" data-toggle="modal" data-target="#modal-countdown-{{$val->id}}">Set Countdown</a></li>
                      @endif
	                  </ul>
                	</div>
                </td>
                </tr>
                @endforeach
              </table>
              {{$result->links()}}
            </div>
            <!-- /.box-body -->
          </div>
          @include('product.product-manage.modal.countdown')
	</div>
</section>

@endsection