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
              <table class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Wallet</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($result as $key => $val)
                <tr>
                <td>{{$val->first_name . ' ' . $val->last_name}}</td>
                <td>{{$val->email}}</td>
                <td>{{$val->phone}}</td>
                <td>{{moneyFormat($val->wallet)}}</td>
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
                        @if($val->status == 1)
                        <li><a href="{{ route($page.'.change-status', ['id' => $val->id, 'status' => 0]) }}">Block</a></li>
                        @else
                        <li><a href="{{ route($page.'.change-status', ['id' => $val->id, 'status' => 1]) }}">Unblock</a></li>
                        @endif
                        <li class="divider"></li>
                        <li><a style="cursor: pointer;" data-toggle="modal" data-target="#modal-wallet-{{$val->id}}">View Wallet Log</a></li>
                        <li><a style="cursor: pointer;" data-toggle="modal" data-target="#modal-wallet-adjustment-{{$val->id}}">Adjust Wallet</a></li>
                    </ul>
                  </div>
                </td>
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          @include('master.customer.modal.wallet-log')
          @include('master.customer.modal.wallet-adjustment')
  </div>
</section>

@endsection