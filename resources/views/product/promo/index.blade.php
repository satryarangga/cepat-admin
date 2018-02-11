@extends('layout.main')

@section('title', 'Home')

@section('content')

<section class="content">
  <div class="col-md-12">
    {!! session('displayMessage') !!}
    <div class="box">
            <div class="box-header">
                <a href="{{route($page.'.create')}}" class="btn btn-info">Create {{ucwords(str_replace('-',' ', $page))}}</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Start On</th>
                  <th>End On</th>
                  <th>Countdown</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($result as $key => $val)
                <tr>
                <td>{{$val->name}}</td>
                <td>{{date('j F Y H:i:s', strtotime($val->start_on))}}</td>
                <td>{{date('j F Y H:i:s', strtotime($val->end_on))}}</td>
                <td id="countdown-{{$val->id}}">
                  {{($val->status == 2) ? 'Stopped' : 'Not Started' }}
                </td>
                <td id="status-{{$val->id}}">
                  @if($val->status != 2)
                  {!!setActivationStatus($val->status)!!}
                  @else
                  <span class="btn btn-danger">Stopped</span>
                  @endif
                </td>
                <td>
                  <div class="btn-group">
                    <button type="button" class="btn btn-info">Action</button>
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ route($page.'.edit', ['id' => $val->id]) }}">Edit</a></li>
                        <li><a href="{{ route($page.'.manage-product', ['id' => $val->id]) }}">Manage Product</a></li>
                        @if($val->status != 2)
                        <li><a onclick="return confirm('You will stop this promo, continue?')" href="{{ route($page.'.change-status', ['id' => $val->id, 'status' => 2]) }}">Stop</a></li>
                        @else
                        <li><a onclick="return confirm('You will reactivate this promo, continue?')" href="{{ route($page.'.change-status', ['id' => $val->id, 'status' => 1]) }}">Reactivate</a></li>
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