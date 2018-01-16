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
                  <th>Store Name</th>
                  <th>Owner Name</th>
                  <th>Email</th>
                  <th>Handphone Number</th>
                  <th>Location</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($result as $key => $val)
                <tr>
                <td>{{$val->store_name}}</td>
                <td>{{$val->owner_name}}</td>
                <td>{{$val->email}}</td>
                <td>{{$val->handphone_number}}</td>
                <td>{{getFieldOfTable('provinces', $val->province_id, 'name') . '-' . getFieldOfTable('cities', $val->city_id, 'name')}}</td>
                <td>{!!setActivationStatus($val->status)!!}</td>
                <td>
                  <div class="btn-group">
                    <button type="button" class="btn btn-info">Action</button>
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ route($page.'.edit', ['id' => $val->id]) }}">Edit</a></li>
                        @if($val->id != 1)
                        @if($val->status == 1)
                        <li><a href="{{ route($page.'.change-status', ['id' => $val->id, 'status' => 0]) }}">Block</a></li>
                        @else
                        <li><a href="{{ route($page.'.change-status', ['id' => $val->id, 'status' => 1]) }}">Unblock</a></li>
                        @endif
                        <li>
                          <form class="deleteForm" method="post" action="{{route("$page.destroy", ['id' => $val->id])}}">
                            {{csrf_field()}}
                            <button onclick="return confirm('You will delete this {{$page}}, continue')" type="submit">Delete</button>
                            {{ method_field('DELETE') }}
                          </form>
                       </li>
                       @endif
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