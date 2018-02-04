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
              <li @if($page == 'product') class="active" @endif>
                <a href="{{route('product-manage.index')}}"><i class="fa fa-folder-open"></i> Product</a>
              </li>
              <li @if($page == 'inventory-control') class="active" @endif>
                <a href="{{route('product-variant.inventoryControl')}}"><i class="fa fa-folder-open"></i> Inventory Control</a>
              </li>
            </ul>
        </li>

        <li class="@if(\Illuminate\Support\Facades\Request::segment(1) == 'order') active @endif treeview">
            <a href="#">
              <i class="fa fa-folder"></i> <span>Order</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li @if($page == 'user') class="active" @endif>
                <a href="{{route('order-partner.index', ['status' => 'all'])}}">
                  <i class="fa fa-money"></i> All
                </a>
                <a href="{{route('order-partner.index', ['status' => 'to_approve'])}}">
                  <i class="fa fa-money"></i> Waiting for Payment
                </a>
                <a href="{{route('order-partner.index', ['status' => 'to_ship'])}}">
                  <i class="fa fa-money"></i> Wait to Ship
                </a>
                <a href="{{route('shipping.checkCost')}}">
                  <i class="fa fa-money"></i> Check Shipping Cost
                </a>
                <a href="{{route('return.index')}}">
                  <i class="fa fa-truck"></i> Return Order
                </a>
              </li>
            </ul>
        </li>

        <li class="@if(\Illuminate\Support\Facades\Request::segment(1) == 'order') active @endif treeview">
            <a href="#">
              <i class="fa fa-folder"></i> <span>Report</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li @if($page == 'report') class="active" @endif>
                <a href="{{route('report.sales')}}"><i class="fa fa-book"></i> Sales Report</a>
              </li>
            </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>