@extends('layout.main')

@section('title', 'Home')

@section('content')

<section class="content">
  <div class="col-md-12">
    {!! session('displayMessage') !!}
    <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                  <th>Purchase Code</th>
                  <th>Product Name</th>
                  <th>Reason</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($result as $key => $val)
                <tr>
                <td>{{$val->purchase_code}}</td>
                <td>{{$val->product_name}}</td>
                <td>{{$val->reason}}</td>
                <td>{!!setActivationStatus($val->status, 'Received')!!}</td>
                <td>
                  <div class="btn-group">
                    <button type="button" class="btn btn-info">Action</button>
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <!-- <li><a href="{{ route($page.'.edit', ['id' => $val->id]) }}">Edit</a></li> -->
                        @if($val->status == 0)
                        <li>
                          <a href="{{ route($page.'.change-status', ['id' => $val->id, 'status' => 1]) }}">Set Received</a>
                        </li>
                        @else
                        <li>
                          <a href="{{ route($page.'.change-status', ['id' => $val->id, 'status' => 0]) }}">Void Received</a>
                        </li>
                        @endif
                        <li class="divider"></li>
                        <li>
                          <form class="deleteForm" method="post" action="{{route("$page.destroy", ['id' => $val->id])}}">
                            {{csrf_field()}}
                            <button onclick="return confirm('You will delete this {{$page}}, continue')" type="submit">Delete</button>
                            {{ method_field('DELETE') }}
                          </form>
                        </li>
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
</section>

@endsection