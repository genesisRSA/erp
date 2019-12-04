@extends('layouts.main')

@section('title',ucwords($page))

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <h3><a href="{{ route('mytimekeeping').'#cs' }}" class="mr-3"><i class="fas fa-arrow-left"></i></a> File Change Shift</h3>
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
            <form method="POST" action="{{ route('cs.store') }}" enctype="multipart/form-data">
                @csrf
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#cs" role="tab" aria-controls="cs" aria-selected="true">Change Shift Information</a>
                    </li>
                </ul>
                <div class="tab-content border border-top-0" id="myTabContent">
                    <!--CS Information-->
                    <div class="tab-pane fade show active" id="cs" role="tabpanel" aria-labelledby="cs-tab">
                        <div class="container-fluid">
                            <div class="row pt-3 mb-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Type <sup class="text-danger">*</sup></label>
                                        <select class="form-control" name="type" id="type">
                                            <option {{old('type') == 'Change of Shift' ? 'selected' : ''}}>Change of Shift</option>
                                            <option {{old('type') == 'Change of Date' ? 'selected' : ''}}>Change of Date</option>
                                            <option {{old('type') == 'Both' ? 'selected' : ''}}>Both</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Reason for Change <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control" name="reason" id="reason" value="{{old('reason')}}" placeholder="Enter Reason" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Date From (Orig. Sched)<sup class="text-danger">*</sup></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="date" class="form-control" name="date_from" id="date_from" value="{{old('date_from') ? old('date_from') : date('Y-m-d')}}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Orig Schedule (Shift) <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control" name="orig_sched" id="orig_sched" value="{{old('orig_sched')}}" placeholder="Enter Orig Sched" />
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Date To (Orig. Sched)<sup class="text-danger">*</sup></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="date" class="form-control" name="date_to" id="date_to" value="{{old('date_to') ? old('date_to') : date('Y-m-d')}}" readonly/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>New Schedule (Shift) <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control" name="new_sched" id="new_sched" value="{{old('new_sched')}}" placeholder="Enter New Sched"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                </div>
                            </div>
                            @if($reports_to)
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Approver</label><br>
                                        <a href="/{{$reports_to->emp_photo}}" target="_blank"><img src="/{{$reports_to->emp_photo}}" class="img-fluid rounded-circle bg-dark" style="height:48px;"/></a> <span class="badge badge-secondary">{{$reports_to->full_name}}<br>{{$reports_to->emp_no}}</span>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <!--End of CS Information-->
                </div>
                <div class="container-fluid">
                    <div class="row mt-3 float-right">
                        <button type="submit" class="btn btn-success mr-2">Submit</button>
                        <a href="{{ route('mytimekeeping').'#cs' }}" class="btn btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

