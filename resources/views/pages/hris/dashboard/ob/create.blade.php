@extends('layouts.main')

@section('title',ucwords($page))

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <h3><a href="{{ route('mytimekeeping') }}" class="mr-3"><i class="fas fa-arrow-left"></i></a> File Official Business</h3>
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
            <form method="POST" action="{{ route('ob.store') }}" enctype="multipart/form-data">
                @csrf
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#leave" role="tab" aria-controls="leave" aria-selected="true">Official Business Information</a>
                    </li>
                </ul>
                <div class="tab-content border border-top-0" id="myTabContent">
                    <!--OB Information-->
                    <div class="tab-pane fade show active" id="leave" role="tabpanel" aria-labelledby="leave-tab">
                        <div class="container-fluid">
                            <div class="row pt-3 mb-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Purpose <sup class="text-danger">*</sup></label>
                                        <select class="form-control" name="purpose" id="purpose">
                                            <option {{old('purpose') == 'Work' ? 'selected' : ''}}>Work</option>
                                            <option {{old('purpose') == 'Training' ? 'selected' : ''}}>Training</option>
                                            <option {{old('purpose') == 'Seminar' ? 'selected' : ''}}>Seminar</option>
                                            <option {{old('purpose') == 'Others' ? 'selected' : ''}}>Others</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>If "Others" please specify</label>
                                        <input type="text" class="form-control" name="others" id="others" value="{{old('others')}}" placeholder="Others" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Description <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control" name="description" id="description" value="{{old('description')}}" placeholder="Enter Description" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Destination <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control" name="destination" id="destination" value="{{old('destination')}}" placeholder="Enter Destination" />
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Date <sup class="text-danger">*</sup></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="date" class="form-control" name="ob_date" id="ob_date" value="{{old('ob_date') ? old('ob_date') : date('Y-m-d')}}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>From (Hrs.) <sup class="text-danger">*</sup></label>
                                        <input type="number" class="form-control" name="ob_from" id="ob_from" value="{{old('ob_from')}}" placeholder="Enter From" />
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
                                        <a href="/{{$reports_to->emp_photo}}" target="_blank"><img src="/{{$reports_to->emp_photo}}" class="img-fluid rounded-circle bg-dark" style="height:48px;"/></a> <span class="badge badge-secondary">{{$reports_to->full_name}}</span>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <!--End of OB Information-->
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

