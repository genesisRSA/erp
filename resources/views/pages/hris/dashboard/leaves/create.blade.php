@extends('layouts.main')

@section('title',ucwords($page))

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <h3><a href="{{ route('mytimekeeping') }}" class="mr-3"><i class="fas fa-arrow-left"></i></a> File Leave</h3>
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
            <form method="POST" action="{{ route('leave.store') }}" enctype="multipart/form-data">
                @csrf
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#leave" role="tab" aria-controls="leave" aria-selected="true">Leave Information</a>
                    </li>
                </ul>
                <div class="tab-content border border-top-0" id="myTabContent">
                    <!--Leave Information-->
                    <div class="tab-pane fade show active" id="leave" role="tabpanel" aria-labelledby="leave-tab">
                        <div class="container-fluid">
                            <div class="row pt-3 mb-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Leave Type <sup class="text-danger">*</sup></label>
                                        <select class="form-control" name="type" id="type">
                                            <option {{old('type') == 'Sick Leave' ? 'selected' : ''}}>Sick Leave</option>
                                            <option {{old('type') == 'Vacation Leave' ? 'selected' : ''}}>Vacation Leave</option>
                                            <option {{old('type') == 'Emergency Leave' ? 'selected' : ''}}>Emergency Leave</option>
                                            <option {{old('type') == 'Maternal Leave' ? 'selected' : ''}}>Maternal Leave</option>
                                            <option {{old('type') == 'Paternal Leave' ? 'selected' : ''}}>Paternal Leave</option>
                                            <option {{old('type') == 'Unpaid Leave' ? 'selected' : ''}}>Unpaid Leave</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Date From <sup class="text-danger">*</sup></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="date" class="form-control" name="leave_from" id="leave_from" value="{{old('leave_from') ? old('leave_from') : date('Y-m-d')}}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Date To <sup class="text-danger">*</sup></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="date" class="form-control {{ $errors->has('leave_to') ? 'is-invalid' : '' }}" name="leave_to" id="leave_to" value="{{old('leave_to') ? old('leave_to') : date('Y-m-d')}}" {{old('is_one_day') ? 'readonly' : ''}}/>
                                            <div class="invalid-feedback">
                                                {{ $errors->first('leave_to') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Date Range Option</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="is_one_day" class="custom-control-input" id="is_one_day" {{old('is_one_day') ? 'checked' : ''}}>
                                        <label class="custom-control-label" for="is_one_day">Is One Day ?</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Details <sup class="text-danger">*</sup></label>
                                        <textarea class="form-control {{ $errors->has('details') ? 'is-invalid' : '' }}" name="details" id="details" rows="3" placeholder="Leave Details">{{old('details')}}</textarea>
                                        <div class="invalid-feedback">
                                            {{ $errors->first('details') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($reports_to)
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Approver</label><br>
                                        <a href="/{{$reports_to->emp_photo}}" target="_blank"><img src="/{{$reports_to->emp_photo}}" class="img-fluid rounded-circle bg-white" style="height:48px;"/></a> <span class="badge badge-secondary">{{$reports_to->full_name}}</span>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <!--End of Leave Information-->
                </div>
                <div class="container-fluid">
                    <div class="row mt-3 float-right">
                        <button type="submit" class="btn btn-success mr-2">Submit</button>
                        <a href="{{ route('mytimekeeping') }}" class="btn btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

