<div class="d-xl-none">
    <div class="d-sm-none mb-5">
        <nav class="navbar fixed-top navbar-dark bg-blue shadow">
            <a class="navbar-brand" href="#">HRIS</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars fa-2x text-white "></i>
            </button>
            <div class="collapse navbar-collapse mt-2" id="navbarNav">
                <ul class="navbar-nav bg-white mb-3 rounded">
                    <li class="nav-item p-1">
                        <a class="text-dark"><img class="img-fluid user-logo-mini  rounded-circle bg-dark" src="/{{ Auth::user()->employee->emp_photo }}" alt="user-logo"/> <strong>{{ Auth::user()->name }}</strong></a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item p-1 @if($page=="home") active rounded bg-blue-dark @endif">
                        <a class="nav-link" href="/hris/home"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item p-1 @if($page=="my attendance") active rounded bg-blue-dark @endif">
                        <a class="nav-link" href="/hris/myattendance"><i class="far fa-calendar-alt"></i> My Attendance</a>
                    </li>
                    <li class="nav-item p-1">
                        <a class="nav-link" href="/hris/mytimekeeping"><i class="far fa-calendar-check"></i> My Timekeeping</a>
                    </li>

                    @if(Auth::user()->is_admin || Auth::user()->is_hr)
                        <li class="nav-item p-1">
                            <a class="nav-link" href="/hris/attendance"><i class="fas fa-calendar-alt"></i> Attendance</a>
                        </li>
                        <li class="nav-item p-1">
                            <a class="nav-link" href="/hris/timekeeping"><i class="fas fa-calendar-check"></i> Timekeeping</a>
                        </li>
                        <li class="nav-item p-1">
                            <a class="nav-link" href="/hris/employees"><i class="fas fa-users"></i> Employees</a>
                        </li>
                        <li class="nav-item p-1">
                            <a class="nav-link" href="/hris/reports"><i class="fas fa-chart-line"></i> Reports</a>
                        </li>
                    @endif
                </ul>
                <ul class="navbar-nav bg-blue-dark mt-3 mb-3 rounded">
                    <li class="nav-item pl-2 pt-3">
                        <a class="nav-link text-white" id="settings"><i class="fas fa-cog"></i> Account Settings</a>
                    </li>
                    <li class="nav-item pl-2 pb-3">
                        <a class="nav-link text-danger" id="signout"><i class="fas fa-power-off"></i> Sign Out</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>