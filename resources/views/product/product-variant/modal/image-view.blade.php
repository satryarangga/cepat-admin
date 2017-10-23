@foreach($resultPerColor['data'] as $key => $val)
<div class="modal fade" id="modal-image-view-{{$val->color_id}}">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Variant color <b>{{getFieldOfTable('colors', $val->color_id, 'name')}}</b> image list</h4>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-hover table-striped">
            <thead>
              <tr>
                <th>Image</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @if(isset($resultPerImage[$val->color_id]))
                @foreach($resultPerImage[$val->color_id] as $keySize => $valImage)
                <tr class="{{$val->color_id}}">
                  <td><img style="height: 150px" src="{{asset('images/product').'/'.$val->product_id.'/'.$val->color_id.'/'.$valImage->url}}"></td>
                  <td class="buttonStatus">
                      <a onclick="deleteImage($(this), {{$valImage->id}})" class="btn btn-warning">Delete</a>
                  </td>
                </tr>
                @endforeach
              @endif
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