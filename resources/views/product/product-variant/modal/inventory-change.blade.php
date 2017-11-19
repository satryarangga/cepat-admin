@foreach($list as $key => $val)
<div class="modal fade" id="modal-change-inventory-{{$val->SKU}}">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Change Inventory SKU <b>{{$val->SKU}}</b></h4>
      </div>
      <div class="modal-body">
      	<form class="form-horizontal" action="{{route('product-variant.changeInventory')}}" method="post">
      		{{csrf_field()}}
      		<div class="box-body">
	      		<div class="form-group">
	      			<label class="label-control">Current Inventory Warehouse</label>
	      			<input type="number" readonly name="current" value="{{$val->qty_warehouse}}" class="form-control">
	      		</div>
	      		<div class="form-group">
	      			<label class="label-control">New Inventory Warehouse</label>
	      			<input type="number" name="new" class="form-control">
	      		</div>
	      		<div class="form-group">
	      			<label class="label-control">Reason</label>
	      			<textarea class="form-control" name="reason" rows="5"></textarea>
	      		</div>
	      		<div class="form-group">
	      			<input type="hidden" name="sku" value="{{$val->SKU}}">
	      			<input type="submit" value="Change" class="btn btn-primary">
	      		</div>
      		</div>
      		{{ method_field('PUT') }}
      	</form>
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