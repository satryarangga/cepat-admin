<div class="form-group">
  <label for="option" class="col-sm-3 control-label">Product Option</label>
  <div class="col-sm-8">
  	<select class="form-control" id="option">
  		<option>Select Option</option>
  		@foreach($options as $key => $val)
  		<option value="{{$val->id}}">{{$val->name}}</option>
  		@endforeach
  	</select>
  </div>
</div>

<div class="form-group">
  <label for="option" class="col-sm-3 control-label">Option Value</label>
  <div class="col-sm-6">
  	<select class="form-control" id="option-value">
  		<option>Select Value</option>
  	</select>
  </div>
  <a id="add-option" style="cursor: pointer;" class="col-sm-2 btn btn-primary">Add Option Value</a>
</div>

<div class="form-group">
  <label for="option" class="col-sm-3 control-label">Selected Option Value</label>
  <div class="col-sm-8">
  	<table class="table table-bordered table-hover table-striped">
  		<thead>
  			<tr>
  				<th>Option</th>
  				<th>Value</th>
  				<th>Action</th>
  			</tr>
  		</thead>
  		<tbody id="data-option">
  			@if(isset($mapOption))
  				@foreach($mapOption as $key => $val)
  					<tr id="{{$val->product_option_value_id}}">
  						<td>{{getFieldOfTable('product_options', $val->product_option_id, 'name')}}</td>
  						<td>{{getFieldOfTable('product_option_values', $val->product_option_value_id, 'name')}}</td>
  						<td>
  							<a onclick="removeParent({{$val->product_option_value_id}})" class="btn btn-danger">Remove</a>
  							<input type="hidden" name="options[]" value="{{$val->product_option_id}};{{$val->product_option_value_id}}">
  						</td>
  					</tr>
  				@endforeach
  			@endif
  		</tbody>
  	</table>
  </div>
</div>