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
	            <form class="form-horizontal" action="{{route("$page.update", ['id' => $row->id])}}" method="post" enctype="multipart/form-data">
	            	{{csrf_field()}}
	              <div class="box-body">
	                <div class="form-group">
	                  <img src="{{asset('images/banner/'.$row->filename)}}" style="width: 200px; height: 200px" />
	                  <label for="logo" class="col-sm-2 control-label">Banner Image</label>
	                  <div class="col-sm-10">
	                  	<input type="file" name="filename">
	                  </div>
	                </div>
	                <div class="form-group">
	                  <label for="position" class="col-sm-2 control-label">Position</label>
	                  <div class="col-sm-10">
	                    <input type="text" class="form-control" name="position" value="{{$row->position}}" id="position" placeholder="Caption">
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="link" class="col-sm-2 control-label">Link</label>
	                  <div class="col-sm-10">
	                    <input type="text" class="form-control" name="link" value="{{$row->link}}" id="link" placeholder="Link">
	                  </div>
	                </div>

	                <div class="form-group">
			            <label for="target" class="col-sm-2 control-label">Target</label>
			            <div class="col-sm-10">
				            <label class="radio-inline">
				            	<input @if($row->target == 1) checked="checked" @endif type="radio" value="1" name="target">Open New Tab
				            </label>
				            <label class="radio-inline">
				            	<input @if($row->target == 2) checked="checked" @endif type="radio" value="2" name="target">Open Same Tab
				            </label>
			               </div>
			         </div>

	              </div>
	              <!-- /.box-body -->
	              
	              <!-- /.box-footer -->
	              {{ method_field('PUT') }}
		            <!-- /.tab-content -->
		            <div class="box-footer">
	                	<button type="submit" class="btn btn-info">Submit</button>
	              	</div>
	            </form>
	          </div>
          </div>

    </section>

@endsection