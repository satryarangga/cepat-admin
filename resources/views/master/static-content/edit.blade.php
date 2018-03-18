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
	            <form class="form-horizontal" action="{{route("$page.update", ['id' => $row['id']])}}" method="post" enctype="multipart/form-data">
	            	{{csrf_field()}}
	             <div class="box-body">
	                <div class="form-group">
	                  <label for="name" class="col-sm-2 control-label">Name</label>
	                  <div class="col-sm-10">
	                    <input type="text" class="form-control" name="name" value="{{$row['name']}}" id="name" placeholder="Name">
	                  </div>
	                </div>

	                <div class="form-group">
			               <label for="gender" class="col-sm-2 control-label">Type</label>
			               <div class="col-sm-10">
				               <label class="radio-inline"><input @if(!isset($row['type']) || $row['type'] == 1) checked="checked" @endif type="radio" value="1" name="type">Text</label>
		                  	   <label class="radio-inline"><input @if(isset($row['type']) && $row['type'] == 2) checked="checked" @endif type="radio" value="2" name="type">Value</label>
			               </div>
			         </div>

	                <div class="form-group" id="text-content" style="@if(isset($row['type']) && $row['type'] == 2) display: none @endif">
	                  <label for="name" class="col-sm-2 control-label">Content</label>
	                  <div class="col-sm-10">
	                  	<textarea name="content_text" class="form-control textarea">{{$row['content']}}</textarea>
	                  </div>
	                </div>

	                <div class="form-group" id="value-content" style="@if(!isset($row['type']) || $row['type'] == 1) display: none @endif">
	                  <label for="name" class="col-sm-2 control-label">Content</label>
	                  <div class="col-sm-10">
	                  	<input type="text" class="form-control" name="content_value" value="{{$row['content']}}">
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