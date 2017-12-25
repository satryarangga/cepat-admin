@extends('layout.main')

@section('title', 'Home')

@section('content')

<section class="content">
	<div class="col-md-12">
		{!! session('displayMessage') !!}

        <div style="margin:20px 0;display: none" class="alert alert-success" id="success-category">
            Success to update category hierarchy
        </div>
		<div class="box">
            <div class="box-header">
                <a href="{{route($page.'.create')}}" class="btn btn-info">Create {{ucwords(str_replace('-',' ', $page))}}</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div style="display: none;" class="overlay">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
                <div id="tree1" style="" data-url="{{route('category.format-list')}}"></div>
            </div>
            <!-- /.box-body -->
          </div>
	</div>
</section>

@endsection