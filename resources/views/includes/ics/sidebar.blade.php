<nav class="csidebar bg-teal d-flex flex-column justify-content-between ">
    <ul class="csidebar-nav ics text-center">
        <li data-toggle="tooltip" data-placement="right" title="Test"><img class="img-fluid user-logo" src="{{url('/images/default-user.png')}}" alt="user-logo"></li>
        <li><a @if($page=="home") {{'class=active'}} @endif href="home" data-toggle="tooltip" data-placement="right" title="Home"><i class="fas fa-home fa-2x"></i></a></li>
        <li><a @if($page=="inventory") {{'class=active'}} @endif href="inventory" data-toggle="tooltip" data-placement="right" title="Inventory Management"><i class="fas fa-dolly-flatbed fa-2x"></i></a></li>
        <li><a @if($page=="area") {{'class=active'}} @endif href="area" data-toggle="tooltip" data-placement="right" title="Area Management"><i class="fas fa-map-marker-alt fa-2x"></i></a></li>
        <li><a @if($page=="barcode") {{'class=active'}} @endif href="barcode" data-toggle="tooltip" data-placement="right" title="Item Barcoding"><i class="fas fa-qrcode fa-2x"></i></a></li>
    </ul>

    
    <ul class="csidebar-nav ics dark text-center">
        <li><a href="settings" data-toggle="tooltip" data-placement="right" title="Account Settings"><i class="fas fa-cog fa-2x"></i></a></li>
        <li><a href="." class="text-danger" data-toggle="tooltip" data-placement="right" title="Sign Out"><i class="fas fa-power-off fa-2x"></i></a></li>
    </ul>
</nav>
    