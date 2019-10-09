@extends('layouts.main')

@section('title',ucwords($page))

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <h3><a href="{{ route('timekeeping', ['#shift']) }}" class="mr-3"><i class="fas fa-arrow-left"></i></a> {{$emp_shift->shift->shift_desc}} : <img src="/{{$emp_shift->employee->emp_photo}}" class="img-fluid rounded-circle bg-white border" style="height:48px;"/> {{$emp_shift->employee->full_name}}</h3>
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
                                        <input type="text" class="form-control" value="{{$emp_shift->date_from}}" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Date To <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control" value="{{$emp_shift->date_to}}" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Shift <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control" value="{{$emp_shift->shift->shift_desc}}" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Employee <sup class="text-danger">*</sup></label><br>
                                        <a href="/{{$emp_shift->employee->emp_photo}}" target="_blank"><img src="/{{$emp_shift->employee->emp_photo}}" class="img-fluid rounded-circle bg-white border" style="height:48px;"/></a> <span class="badge badge-secondary">{{$emp_shift->employee->full_name}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 border">
                                    <strong>Sunday</strong>
                                    <span class="badge badge-{{$shifts->Sunday=='Rest Day' ? 'danger' : 'success'}} float-right mt-1" id="sunday">{{$shifts->Sunday}}</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-2 border">
                                    <strong>Monday</strong>
                                    <span class="badge badge-{{$shifts->Monday=='Rest Day' ? 'danger' : 'success'}} float-right mt-1" id="monday">{{$shifts->Sunday}}</span>
                                </div>
                                <div class="col-md-2 border">
                                    <strong>Tuesday</strong>
                                    <span class="badge badge-{{$shifts->Tuesday=='Rest Day' ? 'danger' : 'success'}} float-right mt-1" id="tuesday">{{$shifts->Monday}}</span>
                                </div>
                                <div class="col-md-2 border">
                                    <strong>Wednesday</strong>
                                    <span class="badge badge-{{$shifts->Wednesday=='Rest Day' ? 'danger' : 'success'}} float-right mt-1" id="wednesday">{{$shifts->Wednesday}}</span>
                                </div>
                                <div class="col-md-2 border">
                                    <strong>Thursday</strong>
                                    <span class="badge badge-{{$shifts->Thursday=='Rest Day' ? 'danger' : 'success'}} float-right mt-1" id="thursday">{{$shifts->Thursday}}</span>
                                </div>
                                <div class="col-md-2 border">
                                    <strong>Friday</strong>
                                    <span class="badge badge-{{$shifts->Friday=='Rest Day' ? 'danger' : 'success'}} float-right mt-1" id="friday">{{$shifts->Friday}}</span>
                                </div>
                                <div class="col-md-2 border">
                                    <strong>Saturday</strong>
                                    <span class="badge badge-{{$shifts->Saturday=='Rest Day' ? 'danger' : 'success'}} float-right mt-1" id="saturday">{{$shifts->Saturday}}</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Remarks</label>
                                        <textarea class="form-control" name="remarks" id="remarks" rows="3" placeholder="Enter Remarks" readonly>{{$emp_shift->remarks}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End of Shift Information-->
                </div>
                <div class="container-fluid">
                    <div class="row mt-3 float-right">
                    </div>
                </div>
            </form>
        </div>
    </div>
 @stop

