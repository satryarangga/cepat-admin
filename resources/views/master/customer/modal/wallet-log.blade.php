@foreach($result as $key => $val)
<div class="modal fade" id="modal-wallet-{{$val->id}}">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Wallet History of {{$val->first_name. ' '. $val->last_name}}</b></h4>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Date</th>
              <th>Description</th>
              <th>Purchase Code</th>
              <th>Amount</th>
            </tr>
          </thead>
          <tbody>
            @foreach($val->wallet_logs as $keyWallet => $valWallet)
            <tr>
              <td>{{date('j F Y H:i:s', strtotime($valWallet->created_at))}}</td>
              <td>{{$valWallet->description}}</td>
              <td>{{$valWallet->purchase_code}}</td>
              <td>{{moneyFormat($valWallet->amount)}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endforeach