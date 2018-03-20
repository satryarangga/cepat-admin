<table class="table table-bordered table-hover table-striped">
	<thead>
		<tr>
			<th>Product Name</th>
			<th>Price</th>
			<th>Weight</th>
			<th>Description</th>
			<th>Color</th>
			<th>Size</th>
			<th>Quantity</th>
		</tr>
	</thead>
	<tbody>
		@foreach($product as $key => $val)
		<tr>
			<td>{{$val->productname}}</td>
			<td>{{moneyFormat($val->price, false)}}</td>
			<td>{{$val->weight}} Kg</td>
			<td>{{$val->description}}</td>
			<td>{{$val->color}}</td>
			<td>{{$val->size}}</td>
			<td>{{$val->quantity}}</td>
		</tr>
		<input type="hidden" name="productname[]" value="{{$val->productname}}">
		<input type="hidden" name="price[]" value="{{$val->price}}">
		<input type="hidden" name="weight[]" value="{{$val->weight}}">
		<input type="hidden" name="description[]" value="{{$val->description}}">
		<input type="hidden" name="size[]" value="{{$val->size}}">
		<input type="hidden" name="color[]" value="{{$val->color}}">
		<input type="hidden" name="quantity[]" value="{{$val->quantity}}">
		@endforeach
	</tbody>
</table>