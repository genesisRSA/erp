<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>WFH Attendance System</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/template.css') }}" rel="stylesheet">
    </head>
    <body class="bg-white">
        <form method="POST" action="{{ route('wfhcheck') }}">
            @csrf
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <img src="{{url('/images/rgclogo.png')}}"/>
                </div>
                <div class="col-md-4">
                    <h1 class="mt-4">WFH Attendance System</h1>
                    <label>{{date('M d, Y')}}</label>
                </div>
            </div>
            <hr> 
            <div class="row mb-3">
                <div class="col-md-12">
                    <label>Enter ID Number</label>
                    <input name="emp_no" type="text" class="form-control" placeholder="e.g 0101-2020" autofocus
                    value="{{$found ? $user->emp_code : ""}}" {{$found ? 'readonly' : ""}}/><br>
                    @if ($found)
                        <input name="emp_code" type="hidden" value="{{$user->emp_code}}">
                        <h3>{{$user->emp_name}}</h3>
                    @else
                        <button class="btn btn-success">Search</button>
                    @endif
                </div>
            </div>
            @if ($found)
            <div class="row">
                <div class="col-md-12">
                        <button name="transact" value="time_in" class="btn btn-outline-dark"
                        {{isset($today_log) && $today_log->time_in ? "disabled" : ""}}>
                            <img src="{{url('/images/next.png')}}" width="128" height="128"/><br>
                            {{isset($today_log) && $today_log->time_in ? $today_log->time_in: "Time In"}}
                        </button>
                    @if (isset($today_log->time_in))
                        <button name="transact" value="ambreak_in" class="btn btn-outline-dark"
                        {{isset($today_log) && $today_log->ambreak_in ? "disabled" : ""}}>
                            <img src="{{url('/images/coffee.png')}}" width="128" height="128"/><br>
                            {{isset($today_log) && $today_log->ambreak_in ? $today_log->ambreak_in: "Break In (AM)"}}
                        </button>
                    @endif   
                    @if (isset($today_log->ambreak_in))
                        <button name="transact" value="ambreak_out" class="btn btn-outline-dark"
                        {{isset($today_log) && $today_log->ambreak_out ? "disabled" : ""}}>
                            <img src="{{url('/images/coffee2.png')}}" width="128" height="128"/><br>
                            {{isset($today_log) && $today_log->ambreak_out ? $today_log->ambreak_out: "Break Out (AM)"}}
                        </button> 
                    @endif   
                    @if (isset($today_log->ambreak_out))
                        <button name="transact" value="lunch_in" class="btn btn-outline-dark"
                        {{isset($today_log) && $today_log->lunch_in ? "disabled" : ""}}>
                            <img src="{{url('/images/food.png')}}" width="128" height="128"/><br>
                            {{isset($today_log) && $today_log->lunch_in ? $today_log->lunch_in: "Lunch In"}}
                        </button>   
                    @endif  
                    @if (isset($today_log->lunch_in))
                        <button name="transact" value="lunch_out" class="btn btn-outline-dark"
                        {{isset($today_log) && $today_log->lunch_out ? "disabled" : ""}}>
                            <img src="{{url('/images/food2.png')}}" width="128" height="128"/><br>
                            {{isset($today_log) && $today_log->lunch_out ? $today_log->lunch_out: "Lunch Out"}}
                        </button>  
                    @endif   
                    @if (isset($today_log->lunch_out))
                        <button name="transact" value="pmbreak_in" class="btn btn-outline-dark"
                        {{isset($today_log) && $today_log->pmbreak_in ? "disabled" : ""}}>
                            <img src="{{url('/images/coffee.png')}}" width="128" height="128"/><br>
                            {{isset($today_log) && $today_log->pmbreak_in ? $today_log->pmbreak_in: "Break In (PM)"}}
                        </button>   
                    @endif   
                    @if (isset($today_log->pmbreak_in))
                        <button name="transact" value="pmbreak_out" class="btn btn-outline-dark"
                        {{isset($today_log) && $today_log->pmbreak_out ? "disabled" : ""}}>
                            <img src="{{url('/images/coffee2.png')}}" width="128" height="128"/><br>
                            {{isset($today_log) && $today_log->pmbreak_out ? $today_log->pmbreak_out: "Break Out (PM)"}}
                        </button>     
                    @endif     
                    @if (isset($today_log->pmbreak_out))
                        <button name="transact" value="time_out" class="btn btn-outline-dark"
                        {{isset($today_log) && $today_log->time_out ? "disabled" : ""}}>
                            <img src="{{url('/images/next2.png')}}" width="128" height="128"/><br>
                            {{isset($today_log) && $today_log->time_out ? $today_log->time_out: "Time Out"}}
                        </button>     
                    @endif     
                </div>
            </div>
            <div class="row m-3">
                <button name="cancel" class="col-md-12 btn btn-danger" value="test">Cancel</button>
            </div>
            @endif
        </div>      
        </form>        
    </body>
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</html>
            