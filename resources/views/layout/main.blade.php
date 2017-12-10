<!DOCTYPE html>
<html>
<head>
    <!-- META AND TITLE
    ================================================== -->
    @include("layout.meta")
    
    <!-- CSS
    ================================================== -->
    @include("layout.css")
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <!-- HEADER
    ================================================== -->
    @include("layout.header")

    <!-- SIDEBAR
    ================================================== -->
    @if($user->user_type == 1)
        @include("layout.sidebar")
    @else
        @include("layout.sidebar-partner")
    @endif

    <div class="content-wrapper">
        <!-- BREADCRUMB
        ================================================== -->
        @include("layout.bread")

        <!-- CONTENT
        ================================================== -->
        @yield("content")

        <div style="clear: both;"></div>
    </div>
  

    <!-- FOOTER
    ================================================== -->
    @include("layout.footer")  

</div>
    <!-- JS
    ================================================== -->
    @include("layout.js")

</body>
</html>
