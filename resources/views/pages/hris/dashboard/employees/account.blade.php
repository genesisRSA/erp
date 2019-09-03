@extends('layouts.main')

@section('title',ucwords($page))

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <h3><a href="{{ route('employees.index') }}" class="mr-3"><i class="fas fa-arrow-left"></i></a> Manage Account</h3>
            <hr>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Error,</strong> Please see fields with <i class="fas fa-times"></i> mark on it.
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <strong>Success,</strong> {{$message}}
                </div>
            @endif
            <form method="POST" action="{{ $user ? route('account.update') : route('account.store') }}" enctype="multipart/form-data">
                @csrf
                @if($user)
                    <input type="hidden" name="user_id" value="{{$user->id ? $user->id : ''}}"/>
                @endif
                
                <input type="hidden" name="emp_no" value="{{$employee->emp_no}}"/>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#account" role="tab" aria-controls="account" aria-selected="true">Account Information</a>
                    </li>
                </ul>
                <div class="tab-content border border-top-0" id="myTabContent">
                    <!--Account Information-->
                    <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
                        <div class="container-fluid">
                            <div class="row pt-3 mb-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name" value="{{$employee->full_name}}" readonly/>
                                    </div>
                                    <div class="form-group">
                                        <label>Username <sup class="text-danger">*</sup></label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                            </div>
                                            <input type="text" class="form-control @if($errors->has('username')) is-invalid @endif" name="username" placeholder="Enter Username" value="{{$user ? $user->username : old('username')}}" {{$user ? 'readonly' : ''}}/>
                                            <div class="invalid-feedback">
                                                {{ $errors->first('username') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 border-right">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control" name="email" value="{{$employee->work_email}}" readonly/>
                                    </div>
                                    <div class="form-group">
                                        <label>Password <sup class="text-danger">*</sup></label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                            </div>
                                            <input type="password" class="form-control @if($errors->has('password')) is-invalid @endif" name="password" value="{{old('password')}}" placeholder="Enter Password"/>
                                            <div class="invalid-feedback">
                                                {{ $errors->first('password') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 border-right">
                                    <div class="form-group">
                                        <strong>Site Permissions</strong>
                                        <div class="custom-control custom-checkbox mt-3">
                                            <input type="checkbox" name="is_admin" class="custom-control-input" id="is_admin" @if($user) {{$user->is_admin ? 'checked' : ''}} @endif {{ old('is_admin') ? 'checked' : ''}}/>
                                            <label class="custom-control-label" for="is_admin">Is Admin ?</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="is_hr" class="custom-control-input" id="is_hr" @if($user) {{$user->is_hr ? 'checked' : ''}} @endif {{old('is_hr') ? 'checked' : ''}} />
                                            <label class="custom-control-label" for="is_hr">Is HR ?</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="is_nurse" class="custom-control-input" id="is_nurse" @if($user) {{$user->is_nurse ? 'checked' : ''}} @endif {{old('is_nurse') ? 'checked' : ''}} />
                                            <label class="custom-control-label" for="is_nurse">Is Nurse ?</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <strong>Approver Permissions</strong>
                                        <div class="custom-control custom-checkbox mt-3">
                                            <input type="checkbox" name="is_lv_approver" class="custom-control-input" id="is_lv_approver" @if($user) {{$user->is_lv_approver ? 'checked' : ''}} @endif {{old('is_lv_approver') ? 'checked' : ''}} />
                                            <label class="custom-control-label" for="is_lv_approver">Is Leave Approver ?</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="is_ot_approver" class="custom-control-input" id="is_ot_approver" @if($user) {{$user->is_ot_approver ? 'checked' : ''}} @endif {{old('is_ot_approver') ? 'checked' : ''}} />
                                            <label class="custom-control-label" for="is_ot_approver">Is Overtime Approver ?</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="is_cs_approver" class="custom-control-input" id="is_cs_approver" @if($user) {{$user->is_cs_approver ? 'checked' : ''}} else {{old('is_cs_approver') ? 'checked' : ''}} @endif/>
                                            <label class="custom-control-label" for="is_cs_approver">Is Change Shift Approver ?</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End of General Information-->
                </div>
                <div class="container-fluid">
                    <div class="row mt-3 float-right">
                        <button type="submit" class="btn btn-success mr-2">Save</button>
                        <a href="{{ route('employees.index') }}" class="btn btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

