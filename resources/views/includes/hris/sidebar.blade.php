<nav class="csidebar bg-blue d-flex flex-column justify-content-between">
    <ul class="csidebar-nav text-center">
        <li data-toggle="tooltip" data-placement="right" title="{{ Auth::user()->name }}"><img class="img-fluid user-logo rounded-circle bg-white" src="/{{ Auth::user()->employee->emp_photo }}" alt="user-logo"></li>
        <li><a @if($page=="home") {{'class=active'}} @endif href="/hris/home" data-toggle="tooltip" data-placement="right" title="Home"><i class="fas fa-home fa-2x"></i></a></li>
        <li><a @if($page=="my attendance") {{'class=active'}} @endif href="/hris/myattendance" data-toggle="tooltip" data-placement="right" title="My Attendance"><i class="far fa-calendar-alt fa-2x"></i></a></li>
        <li><a @if($page=="my timekeeping") {{'class=active'}} @endif href="/hris/mytimekeeping" data-toggle="tooltip" data-placement="right" title="My Timekeeping"><i class="far fa-calendar-check fa-2x"></i></a></li>

        @if(Auth::user()->is_admin || Auth::user()->is_hr)
        <li><a @if($page=="attendance") {{'class=active'}} @endif href="/hris/attendance" data-toggle="tooltip" data-placement="right" title="Attendance"><i class="fas fa-calendar-alt fa-2x"></i></a></li>
        <li><a @if($page=="timekeeping") {{'class=active'}} @endif href="/hris/timekeeping" data-toggle="tooltip" data-placement="right" title="Timekeeping"><i class="fas fa-calendar-check fa-2x"></i></a></li>
        <li><a @if($page=="employees") {{'class=active'}} @endif href="/hris/employees" data-toggle="tooltip" data-placement="right" title="Employees"><i class="fas fa-users fa-2x"></i></a></li>
        <li><a @if($page=="reports") {{'class=active'}} @endif href="/hris/reports" data-toggle="tooltip" data-placement="right" title="Reports"><i class="fas fa-chart-line fa-2x"></i></a></li>
        
        @endif
    </ul>
    
    <ul class="csidebar-nav dark text-center align-items-end">
        <li><a href="#" id="settings" data-toggle="tooltip" data-placement="right" title="Account Settings"><i class="fas fa-cog fa-2x"></i></a></li>
        <li><a href="#" id="signout" class="text-danger" data-toggle="tooltip" data-placement="right" title="Sign Out"><i class="fas fa-power-off fa-2x"></i></a></li>
    </ul>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</nav>
    