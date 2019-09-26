<nav class="csidebar bg-teal d-flex flex-column justify-content-between">
    <ul class="csidebar-nav ics text-center">
        <li data-toggle="tooltip" data-placement="right" title="{{ Auth::user()->name }}"><img class="img-fluid user-logo rounded-circle bg-white" src="/{{ Auth::user()->employee->emp_photo }}" alt="user-logo"></li>
        <li><a @if($page=="home") {{'class=active'}} @endif href="home" data-toggle="tooltip" data-placement="right" title="Home"><i class="fas fa-home fa-2x"></i></a></li>
        <li><a @if($page=="inventory stock") {{'class=active'}} @endif href="inventory_stock" data-toggle="tooltip" data-placement="right" title="Inventory Stock"><i class="fas fa-pallet fa-2x"></i></a></li>
        <li><a @if($page=="asset barcoding") {{'class=active'}} @endif href="asset_barcoding" data-toggle="tooltip" data-placement="right" title="Asset Barcoding"><i class="fas fa-qrcode fa-2x"></i></a></li>

        @if(Auth::user()->is_admin)
        <li><a @if($page=="reports") {{'class=active'}} @endif href="reports" data-toggle="tooltip" data-placement="right" title="Reports"><i class="fas fa-chart-line fa-2x"></i></a></li>
        
        @endif
    </ul>
    
    <ul class="csidebar-nav ics dark text-center align-items-end">
        <li><a href="settings" data-toggle="tooltip" data-placement="right" title="Account Settings"><i class="fas fa-cog fa-2x"></i></a></li>
        <li><a href="#" id="signout" class="text-danger" data-toggle="tooltip" data-placement="right" title="Sign Out"><i class="fas fa-power-off fa-2x"></i></a></li>
    </ul>
    <form id="logout-form" action="{{ route('ics.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</nav>
    