@foreach($resultPerColor['data'] as $key => $val)
<div class="modal fade" id="modal-view-add-{{$val->color_id}}">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Add new size for <b>{{getFieldOfTable('colors', $val->color_id, 'name')}}</b></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" onsubmit="return submitSize($(this))" action="{{route("$page.store")}}" method="post" enctype="multipart/form-data">
          {{csrf_field()}}
          <div class="box-body">
            <div style="margin:20px 0;display: none;" class="alert alert-danger size-error">Please Choose Size</div>
            <div style="margin:20px 0;display: none" class="alert alert-danger qty-error">Please Input Quantity</div>
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Size</label>
              <div class="col-sm-8">
                <select name="size_id" class="form-control size">
                  <option selected disabled>Choose Size</option>
                  @php $size = App\Models\Size::getAvailableSize($val->product_id, $val->color_id); @endphp
                  @foreach($size as $keySize => $valSize)
                  <option @if(old('size_id') == $valSize->id) selected @endif value="{{$valSize->id}}">{{$valSize->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="qty" class="col-sm-3 control-label">Quantity</label>
              <div class="col-sm-8">
                <input type="text" class="form-control qty" name="qty" value="{{old('qty')}}" id="qty" placeholder="Quantity">
              </div>
            </div>

          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <input type="hidden" name="product_id" value="{{$val->product_id}}">
            <input type="hidden" name="color_id" value="{{$val->color_id}}">
            <button type="submit" class="btn btn-info pull-right">Submit</button>
          </div>
          <!-- /.box-footer -->
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endforeach