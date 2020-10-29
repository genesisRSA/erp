<nav class="csidebar bg-teal d-flex flex-column justify-content-between">
    <ul class="csidebar-nav ics text-center">
        <li data-toggle="tooltip" data-placement="right" title="{{ Auth::user()->name }}"><img class="img-fluid user-logo rounded-circle bg-white" src="/{{ Auth::user()->employee->emp_photo }}" alt="user-logo"></li>
        <li><a @if($page=="home") {{'class=active'}} @endif href="home" data-toggle="tooltip" data-placement="right" title="Home"><i class="fas fa-home fa-2x"></i></a></li>
        <li><a @if($page=="digital signage") {{'class=active'}} @endif href="signages" data-toggle="tooltip" data-placement="right" title="Digital Signage"><i class="fas fa-tablet-alt fa-2x"></i></i></a></li>
       
    </ul>
    
    <ul class="csidebar-nav ics dark text-center align-items-end">
        <li><a href="#" id="settings" data-toggle="tooltip" data-placement="right" title="Account Settings"><i class="fas fa-cog fa-2x"></i></a></li>
        <li><a href="#" id="signout" class="text-danger" data-toggle="tooltip" data-placement="right" title="Sign Out"><i class="fas fa-power-off fa-2x"></i></a></li>
    </ul>
    <form id="logout-form" action="{{ route('ics.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</nav>
    