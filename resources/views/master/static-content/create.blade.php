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
	                  <label for="name" class="col-sm-2 control-label">Name</label>
	                  <div class="col-sm-10">
	                    <input type="text" class="form-control" name="name" value="{{old('name')}}" id="name" placeholder="Name">
	                  </div>
	                </div>

	                <div class="form-group">
			               <label for="gender" class="col-sm-2 control-label">Type</label>
			               <div class="col-sm-10">
				               <label class="radio-inline"><input @if(old('type') == 1) checked="checked" @endif type="radio" value="1" name="type">Text</label>
		                  	   <label class="radio-inline"><input @if(old('type') == 2) checked="checked" @endif type="radio" value="2" name="type">Value</label>
			               </div>
			         </div> 

	                <div class="form-group" id="text-content" style="display: none">
	                  <label for="name" class="col-sm-2 control-label">Content</label>
	                  <div class="col-sm-10">
	                  	<textarea name="content_text" class="form-control textarea"></textarea>
	                  </div>
	                </div>

	                <div class="form-group" id="value-content" style="display: none">
	                  <label for="name" class="col-sm-2 control-label">Content</label>
	                  <div class="col-sm-10">
	                  	<input type="text" class="form-control" name="content_value">
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