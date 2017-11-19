@foreach($list as $key => $val)
<div class="modal fade" id="modal-inventory-log-{{$val->SKU}}">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Inventory Log SKU <b>{{$val->SKU}}</b></h4>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-hover table-striped">
            <thead>
              <tr>
                <td>Description</td>
                <td>Quantity</td>
                <td>Purchase Code</td>
                <td>Source</td>
                <td>Executed By</td>
              </tr>
            </thead>
            <tbody>
              @foreach($val->logs as $keyLogs => $valLogs)
              <tr>
                <td>{{$valLogs->description}}</td>
                <td>{{$valLogs->qty}}</td>
                <td>{{$valLogs->purchase_code}}</td>
                <td>{{$inventoryLog->getSource($valLogs->source)}}</td>
                <td>{{getFieldOfTable('users', $valLogs->user_id, 'username')}}</td>
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