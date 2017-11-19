@foreach($resultPerColor as $key => $val)
<div class="modal fade" id="modal-view-size-{{$val->color_id}}">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Variant color <b>{{getFieldOfTable('colors', $val->color_id, 'name')}}</b> size list</h4>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-hover table-striped">
            <thead>
              <tr>
                <th>Size</th>
                <th>SKU</th>
                <th>Qty Order</th>
                <th>Qty Warehouse</th>
              </tr>
            </thead>
            <tbody>
              @foreach($resultPerSize[$val->color_id] as $keySize => $valSize)
              <tr>
                <td>{{getFieldOfTable('size', $valSize->size_id, 'name')}}</td>
                <td>{{$valSize->SKU}}</td>
                <td>{{$valSize->qty_order}}</td>
                <td>{{$valSize->qty_warehouse}}</td>
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