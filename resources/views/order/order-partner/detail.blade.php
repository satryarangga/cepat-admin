@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div class="pad margin no-print">
      @if($payment->status == 2)
      <div class="callout callout-success" style="margin-bottom: 0!important;">
        <b style="font-size: 20px">PAID</b>
      </div>
      @else
        <div class="callout callout-danger" style="margin-bottom: 0!important;">
          <b style="font-size: 20px">UNPAID</b>
        </div>
      @endif
    </div>

    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> AdminLTE, Inc.
            <small class="pull-right">Date: {{date('j F Y', strtotime($head->date))}}</small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-6 invoice-col">
          <b style="font-size: 18px">Customer Detail</b>
          <address>
            <strong>John Doe</strong><br>
            795 Folsom Ave, Suite 600<br>
            San Francisco, CA 94107<br>
            Phone: (555) 539-1037<br>
            Email: john.doe@example.com
          </address>
        </div>
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped table-bordered">
            <thead>
            <tr>
              <th>Product</th>
              <th>SKU</th>
              <th>Qty</th>
              <th>Shipping Status</th>
              <th>Subtotal</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @php $total_purchase = 0; @endphp
            @foreach($items as $key => $val)
            <tr>
              <td><b>{{$val->product_name}}</b><br>Color: <b>{{$val->color_name}}</b><br>Size: <b>{{$val->size_name}}</b></td>
              <td>{{$val->SKU}}</td>
              <td>{{$val->qty}}</td>
              <td>{{setShippingStatus($val->shipping_status)}}</td>
              <td>{{moneyFormat($val->subtotal)}}</td>
              <td>
                <div class="btn-group">
                    <button type="button" class="btn btn-info">Action</button>
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                      @if($payment->status == 2)
                      <li><a data-toggle="modal" style="cursor: pointer;" data-target="#modal-ship-{{$val->id}}">Set Shipment</a></li>
                      @endif
                    </ul>
                </div>
              </td>
            </tr>
            @php $total_purchase += $val->subtotal @endphp
            @endforeach
            <tr>
              <td colspan="4" style="text-align: right;font-size: 18px;font-weight: bold;">Total Purchase</td>
              <td colspan="3" style="font-size: 18px;font-weight: bold;">{{moneyFormat($total_purchase)}}</td>
            </tr>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
          <button type="button" class="btn btn-primary pull-right hide" style="margin-right: 5px;">
            <i class="fa fa-download"></i> Generate PDF
          </button>
        </div>
      </div>
      @include('order.order-manage.modal.ship')
    </section>
    <!-- /.content -->
    <div class="clearfix"></div>

@endsection