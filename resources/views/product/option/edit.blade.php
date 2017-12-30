@extends('layout.main')

@section('title', 'Home')

@section('content')
    <!-- Main content -->
    <section class="content">
    	<div class="col-md-12">
			<div class="box box-info">
	            <div class="box-header with-border">
	              <h3 class="box-title">Edit {{ucwords(str_replace('-',' ', $page))}}</h3>
	            </div>
	            <!-- /.box-header -->
	            <!-- form start -->
	            @foreach($errors->all() as $message)
		            <div style="margin: 20px 0" class="alert alert-error">
		                {{$message}}
		            </div>
		        @endforeach
		        {!! session('displayMessage') !!}
	            <form class="form-horizontal" action="{{route("$page.update", ['id' => $row->id])}}" method="post" enctype="multipart/form-data">
	            	{{csrf_field()}}
	            	<div class="box-body">
		                <div class="form-group">
		                  <label for="name" class="col-sm-3 control-label">Name</label>
		                  <div class="col-sm-8">
		                    <input type="text" class="form-control" name="name" value="{{$row->name}}" id="name" placeholder="Name">
		                  </div>
		                </div>

		                <div class="form-group">
		                  <label for="parent_id" class="col-sm-3 control-label">Category</label>
		                  <div class="col-sm-8">
		                  	<select name="category[]" multiple id="category" class="form-control select2">
		                  		@foreach($category as $key => $val)
		                  			<option @if(in_array($val->id, $categoryMap)) selected @endif value="{{$val->id}}">{{$val->name}}</option>
		                  		@endforeach
		                  	</select>
		                  </div>
		                </div>

		                <div class="form-group">
		                	<label class="col-sm-3 control-label">Values</label>
		                	<div class="col-sm-8">
		                		<table class="table table-bordered table-striped table-hover">
		                			<thead>
		                				<tr>
		                					<th colspan="2"><a data-toggle="modal" data-target="#modal-add-values" class="btn btn-info">Add New Value</a></th>
		                				</tr>
		                			</thead>
		                			<tbody>
		                				@foreach($values as $key => $val)
		                				<tr>
		                					<td>{{$val->name}}</td>
		                					<td>
		                						<a data-toggle="modal" data-target="#modal-edit-values-{{$val->id}}" class="btn btn-primary" style="cursor: pointer;">Edit</a>
		                					</td>
		                					<td><a onclick="return confirm('You will delete this value, continue?')" class="btn btn-danger" href="{{route('option.deleteValue', ['id' => $val->id])}}">Delete</a></td>
		                				</tr>
		                				@endforeach
		                			</tbody>
		                		</table>
		                  </div>
		                </div>

	              </div>
	              <!-- /.box-body -->
	              <div class="box-footer">
	                <button type="submit" class="btn btn-info pull-right">Submit</button>
	              </div>
	              <!-- /.box-footer -->
	              {{ method_field('PUT') }}
	            </form>
	          </div>
          </div>
          @include('product.option.modal.edit-values')
          @include('product.option.modal.add-values')
    </section>

@endsection