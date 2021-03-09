<nav class="csidebar bg-red d-flex flex-column justify-content-between">
    <ul class="csidebar-nav dcs text-center">
        <li data-toggle="tooltip" data-placement="right" title="{{ Auth::user()->name }}"><img class="img-fluid user-logo rounded-circle bg-white" src="/{{ Auth::user()->employee->emp_photo }}" alt="user-logo"></li>
        <li><a @if($page=="home") {{'class=active'}} @endif href="home" data-toggle="tooltip" data-placement="right" title="Home"><i class="fas fa-home fa-2x"></i></a></li>
        <li><a @if($page=="projects") {{'class=active'}} @endif href="projects" data-toggle="tooltip" data-placement="right" title="Projects"><i class="fas fa-list fa-2x"></i></a></li>
        <li><a @if($page=="summary") {{'class=active'}} @endif href="summary" data-toggle="tooltip" data-placement="right" title="Summary"><i class="fas fa-money-check fa-2x"></i></a></li>
        <li><a @if($page=="checklist") {{'class=active'}} @endif href="checklist" data-toggle="tooltip" data-placement="right" title="Checklist"><i class="fas fa-tasks fa-2x"></i></a></li>
        
        @if(Auth::user()->is_admin)
        <li><a @if($page=="reports") {{'class=active'}} @endif href="reports" data-toggle="tooltip" data-placement="right" title="Reports"><i class="fas fa-chart-line fa-2x"></i></a></li>
        
        @endif
    </ul>
    
    <ul class="csidebar-nav dcs dark text-center align-items-end">
        <li><a href="settings" data-toggle="tooltip" data-placement="right" title="Account Settings"><i class="fas fa-cog fa-2x"></i></a></li>
        <li><a href="#" id="signout" class="text-danger" data-toggle="tooltip" data-placement="right" title="Sign Out"><i class="fas fa-power-off fa-2x"></i></a></li>
    </ul>
    <form id="logout-form" action="{{ route('reiss.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</nav>
    