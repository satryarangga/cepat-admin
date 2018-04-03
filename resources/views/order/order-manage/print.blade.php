<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Cepat Cepat E-Commerce</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('lte') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('lte') }}/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('lte') }}/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('lte') }}/dist/css/AdminLTE.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
  <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> Invoice #{{$head->purchase_code}}
            <small class="pull-right">Purchase Date: {{date('j F Y', strtotime($head->date))}}</small>
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
        <div class="col-sm-6 pull-right">
          @if($payment->status == 2)
          <label class="label label-success" style="font-size: 28px">PAID</label>
          @else
          <label class="label label-danger" style="font-size: 28px">UNPAID</label>
          @endif
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
  <!-- /.content -->
    </section>
</div>
<!-- ./wrapper -->
</body>
</html>
