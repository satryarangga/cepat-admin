<div class="modal fade" id="modal-add-values">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Add value option {{$row->name}}</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="{{route("option.addValue")}}" method="post" enctype="multipart/form-data">
          {{csrf_field()}}
          <div class="box-body">
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Value</label>
              <div class="col-sm-8">
                <input type="text" class="form-control name" name="name" id="name">
              </div>
            </div>

          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <input type="hidden" name="option_id" value="{{$row->id}}">
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