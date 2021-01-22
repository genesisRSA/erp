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
                                            <option {{old('type') == 'Sick Leave' ? 'selected' : ''}} {{ $leave_credits->sick_leave <= 0 ? 'disabled' : '' }} value="Sick Leave">Sick Leave : {{$leave_credits->sick_leave}}</option>
                                            <option {{old('type') == 'Vacation Leave' ? 'selected' : ''}} {{ $leave_credits->vacation_leave <= 0 ? 'disabled' : '' }} value="Vacation Leave">Vacation Leave : {{$leave_credits->vacation_leave}}</option>
                                            <option {{old('type') == 'Solo Parent Leave' ? 'selected' : ''}} {{ $leave_credits->solo_parent_leave <= 0 ? 'disabled' : '' }} value="Solo Parent Leave">Solo Parent Leave : {{$leave_credits->solo_parent_leave}}</option>
                                            <option {{old('type') == 'Admin Leave' ? 'selected' : ''}} {{ $leave_credits->admin_leave <= 0 ? 'disabled' : '' }} value="Admin Leave">Admin Leave : {{$leave_credits->admin_leave}}</option>
                                            <option {{old('type') == 'Bereavement Leave' ? 'selected' : ''}} {{ $leave_credits->bereavement_leave <= 0 ? 'disabled' : '' }} value="Bereavement Leave">Bereavement Leave : {{$leave_credits->bereavement_leave}}</option>
                                            <option {{old('type') == 'Birthday Leave' ? 'selected' : ''}} {{ $leave_credits->bday_leave <= 0 ? 'disabled' : '' }} value="Birthday Leave">Birthday Leave : {{$leave_credits->bday_leave}}</option>
                                            @if(Auth::user()->employee->gender == "Female")
                                            <option {{old('type') == 'Maternity Leave' ? 'selected' : ''}} {{ $leave_credits->maternity_leave <= 0 ? 'disabled' : '' }} value="Maternity Leave">Maternity Leave : {{$leave_credits->maternity_leave}}</option>
                                            <option {{old('type') == 'Expanded Maternity Leave' ? 'selected' : ''}} {{ $leave_credits->expanded_leave <= 0 ? 'disabled' : '' }} value="Expanded Maternity Leave">Expanded Maternity Leave : {{$leave_credits->expanded_leave}}</option>
                                            <option {{old('type') == 'Special Leave for Women' ? 'selected' : ''}} {{ $leave_credits->special_leave <= 0 ? 'disabled' : '' }} value="Special Leave for Women">Special Leave for Women : {{$leave_credits->special_leave}}</option>
                                            <option {{old('type') == 'Leave for Abused Women' ? 'selected' : ''}} {{ $leave_credits->abused_leave <= 0 ? 'disabled' : '' }} value="Leave for Abused Women">Leave for Abused Women : {{$leave_credits->abused_leave}}</option>
                                            @else
                                            <option {{old('type') == 'Paternity Leave' ? 'selected' : ''}} {{ $leave_credits->paternity_leave <= 0 ? 'disabled' : '' }} value="Paternity Leave">Paternity Leave : {{$leave_credits->paternity_leave}}</option>
                                            @endif
                                            <option {{old('type') == 'Unpaid Leave' ? 'selected' : ''}} value="Unpaid Leave">Unpaid Leave</option>
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
                                        <!--
                                            <input type="date" class="form-control" min="{{ date('Y-m-d',strtotime('next '.date('l'))) }}" name="leave_from" id="leave_from" value="{{old('leave_from') ? old('leave_from') : date('Y-m-d',strtotime('next '.date('l')))}}" />
                                        -->
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
                                            <input type="date" class="form-control {{ $errors->has('leave_to') ? 'is-invalid' : '' }}" name="leave_to" id="leave_to" value="{{old('leave_to') ? old('leave_to') : date('Y-m-d',strtotime('next '.date('l')))}}" {{old('is_one_day') ? 'readonly' : ''}}/>
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
                                        <label class="custom-control-label" for="is_one_day">Is One Day ?</label><br>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="is_half_day" class="custom-control-input" id="is_half_day" {{old('is_half_day') ? 'checked' : ''}}>
                                        <label class="custom-control-label" for="is_half_day">Is Half Day ?</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>Reason for Leave <sup class="text-danger">*</sup></label>
                                            <div class="input-group">
                                                <textarea class="form-control {{ $errors->has('details') ? 'is-invalid' : '' }}" name="details" id="details" rows="1" placeholder="Please input reason for leave...">{{old('details')}}</textarea>
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('details') }}
                                                </div>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-sm btn-success" id="add_leave"><i class="fas fa-plus-circle"></i> Add Leave</button>
                                                </div>
                                            </div>
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered" id="leave_table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th class="bg-primary" colspan="6">Leave Details</th>
                                            </tr>
                                            <tr>
                                                <th>Leave Type</th>
                                                <th>Date From</th>
                                                <th>Date To</th>
                                                <th>Duration</th>
                                                <th>Reason for Leave</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(old('date_from'))
                                                @for ($i = 0; $i < count(old('date_from')); $i++)
                                                    <tr>
                                                        <td>{{old('leave_type.'.$i)}}</td>
                                                        <td>{{old('date_from.'.$i)}}</td>
                                                        <td>{{old('date_to.'.$i)}}</td>
                                                        <td>{{old('duration.'.$i)}}</td>
                                                        <td>{{old('reason.'.$i)}}</td>
                                                        <td><button type="button" class="btn btn-sm btn-danger" id="del_leave"><i class="fas fa-trash-alt"></i> Delete</button></td>
                                                        <input type="hidden" name="leave_type[]" value="{{old('leave_type.'.$i)}}" />
                                                        <input type="hidden" name="date_from[]" value="{{old('date_from.'.$i)}}" />
                                                        <input type="hidden" name="date_to[]" value="{{old('date_to.'.$i)}}" />
                                                        <input type="hidden" name="duration[]" value="{{old('duration.'.$i)}}" />
                                                        <input type="hidden" name="reason[]" value="{{old('reason.'.$i)}}" />
                                                    </td>
                                                @endfor
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @if($reports_to)
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Approver</label><br>
                                        <a href="/{{$reports_to->emp_photo}}" target="_blank"><img src="/{{$reports_to->emp_photo}}" class="img-fluid rounded-circle bg-white" style="height:48px;"/></a> <span class="badge badge-secondary">{{$reports_to->full_name}}<br>{{$reports_to->emp_no}}</span>
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

