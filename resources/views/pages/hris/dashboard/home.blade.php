@extends('layouts.main')

@section('title',ucwords($page))

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <img class="img-fluid mr-3" src="{{url('/images/group.png')}}" />
            <span class="lead">
                @if(date('a')=='am')
                    Good Morning
                @else
                    Good Afternoon
                @endif
                
                {{Auth::user()->name}}!
            </span>
            <hr>
            <p class="card-text">Welcome to our ERIS! The Employee Resource Information System (ERIS) is a software or online solution for the data entry, data tracking, and data information needs of the Human Resources, payroll, management, and accounting functions within a business.</p>
          </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <strong>Success,</strong> {{$message}}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Error,</strong> {{$errors->first()}}
        </div>
    @endif

    @if(Auth::user()->is_admin || Auth::user()->is_hr)
        <div class="row">
            <div class="col-lg-3">
                <div class="card mb-3">
                    <h5 class="card-header bg-primary text-white"><i class="fas fa-calendar-day"></i> Today is {{date('D M d, Y')}}</h5>
                    <div class="card-body">
                        <p><i class="fas fa-birthday-cake"></i> Birthday Celebrant(s) of {{date('F')}}</p>
                        <div class="list-group">
                            @if(count($bday_celebrants)>0)
                                @foreach($bday_celebrants as $member)
                                    <a class="list-group-item list-group-item-action">
                                        <img src="/{{ $member->emp_photo }}" class="img-fluid border bg-dark rounded-circle bg-white mr-2" style="height:32px;"/> <span class="badge badge-secondary">{{ $member->full_name }}</span>
                                        <span class="float-right" style="font-size:9px;">{{ date('M d',strtotime($member->dob)) }}</span>
                                    </a>
                                @endforeach
                            @else
                                <a class="list-group-item list-group-item-action">No data available</a>  
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <h5 class="card-header bg-success text-white"><i class="far fa-thumbs-up"></i> Top 5 Early Comer of the Week</h5>
                    <div class="card-body">
                        <p>Punctuality at its Finest!</p>
                        <div class="list-group">
                            @foreach($week_early as $member)
                                <a class="list-group-item list-group-item-action">
                                    @php $emp = App\Employee::where('emp_no','=',$member->emp_code)->first() @endphp
                                    @if ($emp)
                                    <img src="/{{ $emp ? $emp->emp_photo : 'storage/profile/1566540517.png' }}" class="img-fluid border bg-dark rounded-circle bg-white mr-2" style="height:32px;"/> <span class="badge badge-secondary">{{ $emp->full_name }}</span>
                                    <span class="float-right" style="font-size:9px;">{{ $member->early }} day(s)</span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card mb-3">
                    <h5 class="card-header bg-warning"><i class="fas fa-award"></i> Anniversary</h5>
                    <div class="card-body">
                        <p>Congratule these passionate employees!</p>
                        <div class="list-group">
                            @if(count($anniv_celebrants)>0)
                                @foreach($anniv_celebrants as $member)
                                    <a class="list-group-item list-group-item-action">
                                        <img src="/{{ $member->emp_photo }}" class="img-fluid border bg-dark rounded-circle bg-white mr-2" style="height:32px;"/> <span class="badge badge-secondary">{{ $member->full_name }}</span>
                                        <span class="float-right" style="font-size:9px;">{{date('M d',strtotime($member->date_hired))}} | {{ date('Y')-date('Y',strtotime($member->date_hired)) }} year(s)</span>
                                    </a>
                                @endforeach
                            @else
                                <a class="list-group-item list-group-item-action">No data available</a>  
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <h5 class="card-header bg-danger text-white"><i class="fas fa-exclamation-circle"></i> Top 5 Late Comer of the Week</h5>
                    <div class="card-body">
                        <p>Need some improvement with their punctuality.</p>
                        <div class="list-group">
                            @foreach($week_late as $member)
                                <a class="list-group-item list-group-item-action">
                                    @php $emp = App\Employee::where('emp_no','=',$member->emp_code)->first() @endphp
                                    @if ($emp)
                                    <img src="/{{ $emp ? $emp->emp_photo : 'storage/profile/1566540517.png' }}" class="img-fluid border bg-dark rounded-circle bg-white mr-2" style="height:32px;"/> <span class="badge badge-secondary">{{ $emp->full_name }}</span>
                                    <span class="float-right" style="font-size:9px;">{{ $member->late }} day(s)</span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <h5 class="card-header"><i class="fas fa-sitemap"></i> My Team : Attendance</h5>
                    <div class="card-body">
                        <p>See your team's attendance.</p>
                        <div class="list-group">
                            @foreach(Auth::user()->employee->team->where('emp_cat','<>','Resigned') as $member)
                                <a href="{{ $member->id_no }}/teamattendance" class="list-group-item list-group-item-action">
                                    <img src="/{{ $member->emp_photo }}" class="img-fluid border bg-dark rounded-circle bg-white mr-2" style="height:48px;"/> <span class="badge badge-primary">{{ $member->full_name }}</span>
                                    <i class="fas fa-chevron-right float-right mt-3"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card mb-3">
                    <h5 class="card-header bg-dark text-white"><i class="fas fa-bullhorn"></i> Events and Announcements</h5>
                    <div class="card-body">
                        <!--<a href="#">
                                <div class="card mb-3">
                                    <img src="{{ asset('images/biggest.webp') }}" class="card-img-top" alt="...">
                                    <div class="card-body text-dark">
                                        <h5 class="card-title">Join RGC's the Biggest Loser</h5>
                                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                    </div>
                                </div>
                            </a>-->
                            <div class="list-group">
                                <a class="list-group-item list-group-item-action">No data available</a>  
                            </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        
        <div class="row">
            @if (count(Auth::user()->employee->team) > 0)
                <div class="col-lg-4">
                    <div class="card mb-3">
                        <h5 class="card-header bg-primary text-white"><i class="fas fa-calendar-day"></i> Today is {{date('D M d, Y')}}</h5>
                        <div class="card-body">
                            <p><i class="fas fa-birthday-cake"></i> Birthday Celebrant(s) of {{date('F')}}</p>
                            <div class="list-group">
                                @if(count($bday_celebrants)>0)
                                    @foreach($bday_celebrants as $member)
                                        <a class="list-group-item list-group-item-action">
                                            <img src="/{{ $member->emp_photo }}" class="img-fluid border bg-dark rounded-circle bg-white mr-2" style="height:32px;"/> <span class="badge badge-secondary">{{ $member->full_name }}</span>
                                            <span class="float-right" style="font-size:9px;">{{ date('M d',strtotime($member->dob)) }}</span>
                                        </a>
                                    @endforeach
                                @else
                                    <a class="list-group-item list-group-item-action">No data available</a>  
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <h5 class="card-header bg-warning"><i class="fas fa-award"></i> Anniversary</h5>
                        <div class="card-body">
                            <p>Congratule these passionate employees!</p>
                            <div class="list-group">
                                @if(count($anniv_celebrants)>0)
                                    @foreach($anniv_celebrants as $member)
                                        <a class="list-group-item list-group-item-action">
                                            <img src="/{{ $member->emp_photo }}" class="img-fluid border bg-dark rounded-circle bg-white mr-2" style="height:32px;"/> <span class="badge badge-secondary">{{ $member->full_name }}</span>
                                            <span class="float-right" style="font-size:9px;">{{date('M d',strtotime($member->date_hired))}} | {{ date('Y')-date('Y',strtotime($member->date_hired)) }} year(s)</span>
                                        </a>
                                    @endforeach
                                @else
                                    <a class="list-group-item list-group-item-action">No data available</a>  
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card mb-3">
                        <h5 class="card-header bg-dark text-white"><i class="fas fa-bullhorn"></i> Events and Announcements</h5>
                        <div class="card-body">
                            <!--<a href="#">
                                <div class="card mb-3">
                                    <img src="{{ asset('images/biggest.webp') }}" class="card-img-top" alt="...">
                                    <div class="card-body text-dark">
                                        <h5 class="card-title">Join RGC's the Biggest Loser</h5>
                                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                    </div>
                                </div>
                            </a>-->
                            <div class="list-group">
                                <a class="list-group-item list-group-item-action">No data available</a>  
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card mb-3">
                        <h5 class="card-header"><i class="fas fa-sitemap"></i> My Team : Attendance</h5>
                        <div class="card-body">
                            <p>See your team's attendance.</p>
                            <div class="list-group">
                                @foreach(Auth::user()->employee->team->where('emp_cat','<>','Resigned') as $member)
                                    <a href="{{ $member->id_no }}/teamattendance" class="list-group-item list-group-item-action">
                                        <img src="/{{ $member->emp_photo }}" class="img-fluid border bg-dark rounded-circle bg-white mr-2" style="height:48px;"/> <span class="badge badge-primary">{{ $member->full_name }}</span>
                                        <i class="fas fa-chevron-right float-right mt-3"></i>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-lg-4">
                    <div class="card mb-3">
                        <h5 class="card-header bg-primary text-white"><i class="fas fa-calendar-day"></i> Today is {{date('D M d, Y')}}</h5>
                        <div class="card-body">
                            <p><i class="fas fa-birthday-cake"></i> Birthday Celebrant(s) of {{date('F')}}</p>
                            <div class="list-group">
                                @if(count($bday_celebrants)>0)
                                    @foreach($bday_celebrants as $member)
                                        <a class="list-group-item list-group-item-action">
                                            <img src="/{{ $member->emp_photo }}" class="img-fluid border bg-dark rounded-circle bg-white mr-2" style="height:32px;"/> <span class="badge badge-secondary">{{ $member->full_name }}</span>
                                            <span class="float-right" style="font-size:9px;">{{ date('M d',strtotime($member->dob)) }}</span>
                                        </a>
                                    @endforeach
                                @else
                                    <a class="list-group-item list-group-item-action">No data available</a>  
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <h5 class="card-header bg-warning"><i class="fas fa-award"></i> Anniversary</h5>
                        <div class="card-body">
                            <p>Congratule these passionate employees!</p>
                            <div class="list-group">
                                @if(count($anniv_celebrants)>0)
                                    @foreach($anniv_celebrants as $member)
                                        <a class="list-group-item list-group-item-action">
                                            <img src="/{{ $member->emp_photo }}" class="img-fluid border bg-dark rounded-circle bg-white mr-2" style="height:32px;"/> <span class="badge badge-secondary">{{ $member->full_name }}</span>
                                            <span class="float-right" style="font-size:9px;">{{date('M d',strtotime($member->date_hired))}} | {{ date('Y')-date('Y',strtotime($member->date_hired)) }} year(s)</span>
                                        </a>
                                    @endforeach
                                @else
                                    <a class="list-group-item list-group-item-action">No data available</a>  
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card mb-3">
                        <h5 class="card-header bg-dark text-white"><i class="fas fa-bullhorn"></i> Events and Announcements</h5>
                        <div class="card-body">
                            <!--<a href="#">
                                <div class="card mb-3">
                                    <img src="{{ asset('images/biggest.webp') }}" class="card-img-top" alt="...">
                                    <div class="card-body text-dark">
                                        <h5 class="card-title">Join RGC's the Biggest Loser</h5>
                                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                    </div>
                                </div>
                            </a>-->
                            <div class="list-group">
                                <a class="list-group-item list-group-item-action">No data available</a>  
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        
    @endif

@stop

