@extends('layout.main')

@section('title', 'Home')

@section('content')

<section class="content">
	<div class="row">
    	<div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{$num_order}}</h3>

              <p>Today Orders</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{moneyFormat($num_purchase, true)}}</h3>

              <p>Today Purchase</p>
            </div>
            <div class="icon">
              <i class="fa fa-money"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{$num_user}}</h3>

              <p>Today New User</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{$num_item}}</h3>

              <p>Today Item Sold</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
          </div>
        </div>
	</div>

  <div class="col-md-12">
    <div class="row">
      <div class="nav-tabs-custom">
        <!-- Tabs within a box -->
        <ul class="nav nav-tabs pull-right">
          <li class="pull-left header"><i class="fa fa-inbox"></i> Sales</li>
        </ul>
        <div class="tab-content no-padding">
          <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"></div>
        </div>
      </div>
    </div>
  </div>

</section>

@endsection