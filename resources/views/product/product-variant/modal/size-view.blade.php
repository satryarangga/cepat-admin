@foreach($resultPerColor['data'] as $key => $val)
<div class="modal fade" id="modal-size-view-{{$val->color_id}}">
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
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($resultPerSize[$val->color_id] as $keySize => $valSize)
              @php $sizeName = getFieldOfTable('size', $valSize->size_id, 'name')  @endphp
              <tr class="{{$val->color_id}}">
                <td>{{$sizeName}}</td>
                <td>{{$valSize->SKU}}</td>
                <td>{{$valSize->qty_order}}</td>
                <td>{{$valSize->qty_warehouse}}</td>
                <td class="status">{{($valSize->status == 1) ? 'Active' : 'Not Active'}}</td>
                <td class="buttonStatus">
                    @if($valSize->status == 1)
                      <a onclick="changeStatusSize($(this), 0, {{$valSize->id}}, '{{$sizeName}}')" class="btn btn-danger">Deactivate</a>
                    @else
                      <a onclick="changeStatusSize($(this), 1, {{$valSize->id}}, '{{$sizeName}}')" class="btn btn-success">Activate</a>
                    @endif
                    <a onclick="deleteSize($(this), {{$valSize->id}}, '{{$sizeName}}')" class="btn btn-warning">Delete</a>
                </td>
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