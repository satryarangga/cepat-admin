@foreach($items as $key => $val)
<div class="modal fade" id="modal-ship-{{$val->id}}">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Set Shipment of {{$val->product_name}}. Color: {{$val->color_name}}. Size: {{$val->size_name}}</b></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="post" action="{{route('order-manage.setShipment')}}">
          {{csrf_field()}}
          <div class="form-group">
            <label class="control-label col-sm-3">Shipment Tracking Code</label>
            <div class="col-sm-9">
              <input type="text" name="resi" value="{{$val->resi}}" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3">Shipping Status</label>
            <div class="col-sm-9">
              <select name="status" class="form-control">
                @foreach($shipping_status as $keyShip => $valShip)
                <option @if($val->shipping_status == $keyShip) selected @endif value="{{$keyShip}}">{{$valShip}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3">Notes</label>
            <div class="col-sm-9">
              <textarea name="notes" class="form-control" rows="5">{{$val->shipping_notes}}</textarea>
            </div>
          </div>
          <input type="hidden" name="order_item_id" value="{{$val->id}}">
          {{ method_field('PUT') }}
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-info pull-right">Set Shipment Status</button>
      </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endforeach