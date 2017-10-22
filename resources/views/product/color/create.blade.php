@extends('layout.main')

@section('title', 'Home')

@section('content')
    <!-- Main content -->
    <section class="content">
    	<div class="col-md-12">
			<div class="box box-info">
	            <div class="box-header with-border">
	              <h3 class="box-title">Create New {{ucwords(str_replace('-',' ', $page))}}</h3>
	            </div>
	            <!-- /.box-header -->
	            <!-- form start -->
	            @foreach($errors->all() as $message)
		            <div style="margin: 20px 0" class="alert alert-error">
		                {{$message}}
		            </div>
		        @endforeach
	            <form class="form-horizontal" action="{{route("$page.store")}}" method="post" enctype="multipart/form-data">
	            	{{csrf_field()}}
	              <div class="box-body">
	                <div class="form-group">
	                  <label for="name" class="col-sm-3 control-label">Name</label>
	                  <div class="col-sm-8">
	                    <input type="text" class="form-control" name="name" value="{{old('name')}}" id="name" placeholder="Name">
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="hexa" class="col-sm-3 control-label">Hexa Color</label>
	                  <div class="col-sm-8">
	                    <input type="text" class="form-control colorpicker" name="hexa" value="{{old('hexa')}}" id="hexa" placeholder="Hexa">
	                  </div>
	                </div>

	              </div>
	              <!-- /.box-body -->
	              <div class="box-footer">
	                <button type="submit" class="btn btn-info pull-right">Submit</button>
	              </div>
	              <!-- /.box-footer -->
	            </form>
	          </div>
          </div>
    </section>

@endsection