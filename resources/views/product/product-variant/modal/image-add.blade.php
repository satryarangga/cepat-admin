@foreach($resultPerColor['data'] as $key => $val)
<div class="modal fade" id="modal-image-add-{{$val->color_id}}">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Add new image for <b>{{getFieldOfTable('colors', $val->color_id, 'name')}}</b></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="{{route("$page.addImage")}}" method="post" enctype="multipart/form-data">
          {{csrf_field()}}
          <div class="box-body">
            <div class="form-group">
              <label for="image" class="col-sm-4 control-label">Images *Choose Multiple</label>
              <div class="col-sm-7">
                <input type="file" name="image[]" multiple>
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