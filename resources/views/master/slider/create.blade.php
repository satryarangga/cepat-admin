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
	                  <label for="logo" class="col-sm-2 control-label">Slider Image</label>
	                  <div class="col-sm-10">
	                  	<input type="file" name="filename">
	                  </div>
	                </div>
	                <div class="form-group">
	                  <label for="logo" class="col-sm-2 control-label">Position</label>
	                  <div class="col-sm-10">
	                  	<select class="form-control" name="type">
	                  		<option @if(old('type') == '1') selected @endif value="1">Home - Top</option>
	                  		<option @if(old('type') == '2') selected @endif value="2">Home - Middle</option>
	                  		<option @if(old('type') == '3') selected @endif value="3">Home - Bottom</option>
	                  	</select>
	                  </div>
	                </div>
	                <div class="form-group">
	                  <label for="caption" class="col-sm-2 control-label">Caption</label>
	                  <div class="col-sm-10">
	                    <input type="text" class="form-control" name="caption" value="{{old('caption')}}" id="caption" placeholder="Caption">
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="link" class="col-sm-2 control-label">Link</label>
	                  <div class="col-sm-10">
	                    <input type="text" class="form-control" name="link" value="{{old('link')}}" id="link" placeholder="Link">
	                  </div>
	                </div>

	                <div class="form-group">
			            <label for="target" class="col-sm-2 control-label">Target</label>
			            <div class="col-sm-10">
				            <label class="radio-inline">
				            	<input @if(old('target') == 1) checked="checked" @endif type="radio" value="1" name="target">Open New Tab
				            </label>
				            <label class="radio-inline">
				            	<input @if(old('target') == 2) checked="checked" @endif type="radio" value="2" name="target">Open Same Tab
				            </label>
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