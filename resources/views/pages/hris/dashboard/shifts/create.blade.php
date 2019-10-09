@extends('layouts.main')

@section('title',ucwords($page))

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <h3><a href="{{ route('timekeeping', ['#shift']) }}" class="mr-3"><i class="fas fa-arrow-left"></i></a> Create Shift</h3>
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
            <form method="POST" action="{{ route('employeeshift.store') }}" enctype="multipart/form-data">
                @csrf
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="shift-tab" data-toggle="tab" href="#shift" role="tab" aria-controls="shift" aria-selected="true">Shift Information</a>
                    </li>
                </ul>
                <div class="tab-content border border-top-0" id="myTabContent">
                    <!--Shift Information-->
                    <div class="tab-pane fade show active" id="shift" role="tabpanel" aria-labelledby="shift-tab">
                        <div class="container-fluid">
                            <div class="row pt-3 mb-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Date From <sup class="text-danger">*</sup></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control datepicker" name="date_from" id="date_from" value="{{old('date_from')}}" placeholder="Enter Date From"/>
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
                                            <input type="text" class="form-control" name="date_to" id="date_to" value="{{old('date_to')}}" placeholder="Date To" readonly/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Shift <sup class="text-danger">*</sup></label>
                                        <select class="form-control" name="shift" id="shift">
                                            <option value="" disabled selected>Choose Shift...</option>
                                            @foreach($shifts as $shift)
                                                <option value="{{$shift->shift_code}}" {{old('shift') == $shift->shift_code ? 'selected' : ''}}>{{$shift->shift_desc}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Employee <sup class="text-danger">*</sup></label>
                                        <select class="form-control" name="employee" id="employee">
                                            <option value="" disabled selected>Choose Employee...</option>
                                            @foreach($employees as $emp)
                                                <option value="{{$emp->emp_no}}" {{old('employee') == $emp->emp_no ? 'selected' : ''}}>{{$emp->full_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 border">
                                    <strong>Sunday</strong>
                                    <span class="badge badge-danger float-right mt-1" id="sunday"></span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-2 border">
                                    <strong>Monday</strong>
                                    <span class="badge badge-success float-right mt-1" id="monday"></span>
                                </div>
                                <div class="col-md-2 border">
                                    <strong>Tuesday</strong>
                                    <span class="badge badge-success float-right mt-1" id="tuesday"></span>
                                </div>
                                <div class="col-md-2 border">
                                    <strong>Wednesday</strong>
                                    <span class="badge badge-success float-right mt-1" id="wednesday"></span>
                                </div>
                                <div class="col-md-2 border">
                                    <strong>Thursday</strong>
                                    <span class="badge badge-success float-right mt-1" id="thursday"></span>
                                </div>
                                <div class="col-md-2 border">
                                    <strong>Friday</strong>
                                    <span class="badge badge-success float-right mt-1" id="friday"></span>
                                </div>
                                <div class="col-md-2 border">
                                    <strong>Saturday</strong>
                                    <span class="badge badge-success float-right mt-1" id="saturday"></span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Remarks</label>
                                        <textarea class="form-control" name="remarks" id="remarks" rows="3" placeholder="Enter Remarks">{{old('remarks')}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End of Shift Information-->
                </div>
                <div class="container-fluid">
                    <div class="row mt-3 float-right">
                        <button type="submit" class="btn btn-success mr-2">Submit</button>
                        <a href="{{ route('timekeeping',['#shift']) }}" class="btn btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
 @stop

