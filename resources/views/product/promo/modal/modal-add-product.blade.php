<div class="modal fade" id="modal-add-product">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Add Promo Product</b></h4>
      </div>
      <div class="modal-body">
      	<form class="form-horizontal" action="{{route('promo.add-product')}}" method="post">
      		{{csrf_field()}}
      		<div class="box-body">
            <div class="form-group">
              <label class="control-label col-sm-3">Product Name</label>
              <div class="col-sm-9">
                <select name="product" id="product-list" style="width: 80%" class="form-control select2">
                  <option>Choose Product</option>
                  @foreach($product as $key => $val)
                    <option value="{{$val->id}}">{{$val->name}}</option>
                  @endforeach
                </select>
                @foreach($product as $key => $val)
                <input type="hidden" id="ori_price_{{$val->id}}" value="{{$val->original_price}}">
                @endforeach
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-3">Original Price</label>
              <div class="col-sm-9">
                <input type="text" readonly class="form-control" name="ori_price" id="ori_price">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-3">Promo Price</label>
              <div class="col-sm-9">
                <input type="text" onkeyup="formatMoney($(this))" class="form-control" name="promo_price" id="promo_price">
              </div>
            </div>
	      		<div class="form-group">
              <input type="hidden" name="promo_id" value="{{$promo->id}}">
	      			<input type="submit" value="Add Product" class="btn btn-primary">
	      		</div>
      		</div>
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