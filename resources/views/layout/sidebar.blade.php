<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li @if($page == 'dashboard') class="active" @endif>
                <a href="/"><i class="fa fa-tachometer"></i> <span>Dashboard</span></a>
              </li>
        <li class="@if(\Illuminate\Support\Facades\Request::segment(1) == 'product') active @endif treeview">
            <a href="#">
              <i class="fa fa-folder"></i> <span>Products</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li @if($page == 'color') class="active" @endif>
                <a href="{{route('color.index')}}"><i class="fa fa-paint-brush"></i> Color</a>
              </li>
              <li @if($page == 'size') class="active" @endif>
                <a href="{{route('size.index')}}"><i class="fa fa-blind"></i> Size</a>
              </li>
              <li @if($page == 'category-parent') class="active" @endif>
                <a href="{{route('category-parent.index')}}"><i class="fa fa-folder-open"></i> Category Parent</a>
              </li>
              <li @if($page == 'category-child') class="active" @endif>
                <a href="{{route('category-child.index')}}"><i class="fa fa-folder-open"></i> Category Child</a>
              </li>
              <li @if($page == 'product') class="active" @endif>
                <a href="{{route('product-manage.index')}}"><i class="fa fa-folder-open"></i> Product</a>
              </li>
              <li @if($page == 'inventory-control') class="active" @endif>
                <a href="{{route('product-variant.inventoryControl')}}"><i class="fa fa-folder-open"></i> Inventory Control</a>
              </li>
            </ul>
        </li>

        <li class="@if(\Illuminate\Support\Facades\Request::segment(1) == 'master') active @endif treeview">
            <a href="#">
              <i class="fa fa-folder"></i> <span>Others</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li @if($page == 'user') class="active" @endif>
                <a href="{{route('user.index')}}"><i class="fa fa-user"></i> User Management</a>
              </li>
              <li @if($page == 'customer') class="active" @endif>
                <a href="{{route('customer.index')}}"><i class="fa fa-users"></i> Customer Management</a>
              </li>
              <li @if($page == 'static-content') class="active" @endif>
                <a href="{{route('static-content.index')}}"><i class="fa fa-file"></i> Static Content Management</a>
              </li>
              <li @if($page == 'voucher') class="active" @endif>
                <a href="{{route('voucher.index')}}"><i class="fa fa-usd"></i> Voucher Management</a>
              </li>
              <li @if($page == 'request-partner') class="active" @endif>
                <a href="{{route('request-partner.index')}}"><i class="fa fa-handshake-o"></i> Partner Request</a>
              </li>
            </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>