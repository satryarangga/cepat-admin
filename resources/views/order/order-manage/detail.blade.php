@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div class="pad margin no-print">
      @if($payment->status == 2)
      <div class="callout callout-success" style="margin-bottom: 0!important;">
        <b style="font-size: 20px">PAID</b>
      </div>
      @elseif($payment->status == 3)
      <div class="callout callout-info" style="margin-bottom: 0!important;">
        <b style="font-size: 20px">CANCELLED</b>
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
            <i class="fa fa-globe"></i> Cepat Cepat E-Commerce
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
            <strong>{{$customer->first_name}} {{$customer->last_name}}</strong><br>
            {{$delivery->to_address}}<br>
            {{$delivery->to_city_name}}, {{$delivery->to_province_name}}<br>
            Postcode: {{$delivery->to_postcode}}<br>
            Phone: {{$delivery->to_phone}}<br>
            Email: {{$customer->email}}
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
              <th>Seller</th>
              <th>SKU</th>
              <th>Qty</th>
              <th>Shipping Status</th>
              <th>Subtotal</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $key => $val)
            <tr>
              <td><b>{{$val->product_name}}</b><br>Color: <b>{{$val->color_name}}</b><br>Size: <b>{{$val->size_name}}</b></td>
              <td>{{(isset($val->partner_name)) ? $val->partner_name : 'Internal'}}</td>
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
            @endforeach
            <tr>
              <td colspan="5" style="text-align: right;font-size: 18px;font-weight: bold;">Total Purchase</td>
              <td colspan="3" style="font-size: 18px;font-weight: bold;">{{moneyFormat($head->total_purchase)}}</td>
            </tr>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
          <p class="lead">Payment Method: {{$payment->name}}</p>
          <img style="width: 150px;height: 60px" src="{{asset('images/payment-method/'.$payment->logo)}}" alt="{{$payment->name}}">

          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">{{$payment->desc}}</p>
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          <p class="lead">Amount Due <b>{{$dueDate}}</b></p>

          <div class="table-responsive">
            <table class="table">
              <tr>
                <th colspan="2" style="font-size: 16px;background-color: #f5f5f5;border: 1px solid #e3e3e3">Purchase Detail</th>
              </tr>
              <tr>
                <th style="width:50%">Total Purchase:</th>
                <td>{{moneyFormat($head->total_purchase)}}</td>
              </tr>
              <tr>
                <th>Shipping Cost</th>
                <td>{{moneyFormat($head->shipping_cost)}}</td>
              </tr>
              <tr>
                <th>Paycode</th>
                <td>{{moneyFormat($head->paycode)}}</td>
              </tr>
              <tr>
                <th colspan="2" style="font-size: 16px;background-color: #f5f5f5;border: 1px solid #e3e3e3">Discount</th>
              </tr>
              <tr>
                <th>
                  Voucher
                  @if(isset($discount->voucher_code)) 
                    - {{$discount->voucher_code}} <br />
                    <span style="font-size: 12px;font-style:italic;">{{$discount->voucher_name}}</span>
                  @endif
                </th>
                <td>{{moneyFormat($head->discount)}}</td>
              </tr>
              <tr>
                <th>Credit Used</th>
                <td>{{moneyFormat($head->credit_used)}}</td>
              </tr>
              <tr>
                <th style="font-size: 20px;background-color: #f5f5f5;border: 1px solid #e3e3e3">GRAND TOTAL</th>
                <td style="font-size: 20px;background-color: #f5f5f5;font-weight: bold;border: 1px solid #e3e3e3">{{moneyFormat($head->grand_total)}}</td>
              </tr>
            </table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <a href="{{route('order.print', ['id' => $id])}}" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
          @if($payment->status == 2 && !$isItemShipped)
          <a class="btn btn-danger pull-right" href="{{route('order-manage.changeStatus', ['id' => $id, 'type' => 0])}}" onclick="return confirm('You will void paid status of this order, continue?')">
            <i class="fa fa-credit-card"></i> Void Paid
          </a>
          @elseif($payment->status == 1 || $payment->status == 0)
            <a class="btn btn-success pull-right" href="{{route('order-manage.changeStatus', ['id' => $id, 'type' => 1])}}" onclick="return confirm('You will set this order to paid, continue?')">
              <i class="fa fa-credit-card"></i> Set Paid
            </a>
          @endif
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