@foreach($result as $key => $val)
<div class="modal fade" id="modal-edit-product-{{$val->id}}">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Edit Promo Product</b></h4>
      </div>
      <div class="modal-body">
      	<form class="form-horizontal" action="{{route('promo.update-product')}}" method="post">
      		{{csrf_field()}}
      		<div class="box-body">
            <div class="form-group">
              <label class="control-label col-sm-3">Product Name</label>
              <div class="col-sm-9">
                <select name="product" id="product-list-edit" style="width: 80%" class="form-control select2">
                  <option>Choose Product</option>
                  @foreach($product as $keyProduct => $valProduct)
                    <option @if($val->product_id == $valProduct->id) selected @endif value="{{$valProduct->id}}">{{$valProduct->name}}</option>
                  @endforeach
                </select>
                @foreach($product as $keyProduct => $valProduct)
                <input type="hidden" id="edit_ori_price_{{$valProduct->id}}" value="{{$valProduct->original_price}}">
                @endforeach
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-3">Original Price</label>
              <div class="col-sm-9">
                <input type="text" readonly class="form-control" value="{{moneyFormat($val->original_price, false)}}" name="ori_price" id="edit_ori_price">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-3">Promo Price</label>
              <div class="col-sm-9">
                <input type="text" onkeyup="formatMoney($(this))" class="form-control" value="{{moneyFormat($val->promo_price, false)}}" name="promo_price" id="promo_price">
              </div>
            </div>
	      		<div class="form-group">
              <input type="hidden" name="promo_detail_id" value="{{$val->id}}">
	      			<input type="submit" value="Edit Product" class="btn btn-primary">
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