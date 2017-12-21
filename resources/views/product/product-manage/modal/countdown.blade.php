@foreach($result as $key => $val)
<div class="modal fade" id="modal-countdown-{{$val->id}}">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Set Countdown Timer for {{$val->name}}</b></h4>
      </div>
      <div class="modal-body">
      	<form class="form-horizontal" action="{{route('product-manage.setCountdown')}}" method="post">
      		{{csrf_field()}}
      		<div class="box-body">
            <div class="form-group">
              <label class="label-control">Start Date</label>
              <input type="text" name="start_date" class="form-control datepicker">
            </div>
            <div class="bootstrap-timepicker">
              <div class="form-group">
                <label>Start Time:</label>

                <div class="input-group">
                  <input type="text" name="start_time" class="form-control timepicker">

                  <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                  </div>
                </div>
                <!-- /.input group -->
              </div>
              <!-- /.form group -->
            </div>
	      		<div class="form-group">
	      			<label class="label-control">Time Type</label>
              <select class="form-control" name="type">
                <option value="1">Days</option>
                <option value="2">Hours</option>
                <option value="3">Minutes</option>
                <option value="4">Seconds</option>
              </select>
	      		</div>
            <div class="form-group">
              <label class="label-control">Time Value</label>
              <input type="number" name="value" class="form-control">
            </div>
	      		<div class="form-group">
              <input type="hidden" name="product_id" value="{{$val->id}}">
              <input type="hidden" name="product_name" value="{{$val->name}}">
	      			<input type="submit" value="Set" class="btn btn-primary">
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
@endforeach