<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li @if($page == 'dashboard') class="active" @endif>
          <a href="/"><i class="fa fa-tachometer"></i> <span>Dashboard</span></a>
        </li>
        <li @if($page == 'user') class="active" @endif >
          <a href="{{route('user.index')}}"><i class="fa fa-user"></i> User Management</a>
          <a href="{{route('customer.index')}}"><i class="fa fa-users"></i> Customer Management</a>
          <a href="{{route('static-content.index')}}"><i class="fa fa-file"></i> Static Content Management</a>
          <a href="{{route('voucher.index')}}"><i class="fa fa-usd"></i> Voucher Management</a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>