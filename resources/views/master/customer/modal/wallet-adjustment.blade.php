@foreach($result as $key => $val)
<div class="modal fade" id="modal-wallet-adjustment-{{$val->id}}">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Wallet Adjustment for {{$val->first_name. ' '. $val->last_name}}</b></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="post" action="{{route('customer.adjustWallet')}}">
          {{csrf_field()}}
          <div class="form-group">
            <label class="control-label col-sm-3">Current Amount</label>
            <div class="col-sm-9">
              <input type="text" readonly value="{{moneyFormat($val->wallet, false)}}" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3">New Amount</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" onkeyup="formatMoney($(this))" name="amount">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3">Reason</label>
            <div class="col-sm-9">
              <textarea name="reason" class="form-control" rows="5"></textarea>
            </div>
          </div>
          <input type="hidden" name="customer_id" value="{{$val->id}}">
          {{ method_field('PUT') }}
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-info pull-right">Submit</button>
      </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endforeach