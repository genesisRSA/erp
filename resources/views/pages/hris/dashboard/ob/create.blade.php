@extends('layouts.main')

@section('title',ucwords($page))

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <h3><a href="{{ route('mytimekeeping').'#ob' }}" class="mr-3"><i class="fas fa-arrow-left"></i></a> File Official Business</h3>
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
                                        <label>Date <sup class="text-danger">*</sup></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="date" class="form-control" id="ob_date" value="{{old('ob_date') ? old('ob_date') : date('Y-m-d')}}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>OB Duration From (Time) <sup class="text-danger">*</sup></label>
                                        <input type="time" class="form-control" id="ob_from" value="{{old('ob_from')}}"/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>OB Duration To (Time) <sup class="text-danger">*</sup></label>
                                        <input type="time" class="form-control" id="ob_to" value="{{old('ob_to')}}"/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Destination <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control" id="destination" value="{{old('destination')}}" placeholder="Enter Destination" />
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Purpose <sup class="text-danger">*</sup></label>
                                        <select class="form-control" id="purpose">
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
                                        <input type="text" class="form-control" id="others" value="{{old('others')}}" placeholder="Others" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-success mt-4" id="add_ob"><i class="fas fa-plus-circle"></i> Add OB</button>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered" id="ob_table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th class="bg-primary" colspan="6">Official Business Details</th>
                                            </tr>
                                            <tr>
                                                <th>OB Date</th>
                                                <th>OB Duration From</th>
                                                <th>OB Duration To</th>
                                                <th>Destination</th>
                                                <th>Purpose</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(old('ob_date'))
                                                @for ($i = 0; $i < count(old('ob_date')); $i++)
                                                    <tr>
                                                        <td>{{old('ob_date.'.$i)}}</td>
                                                        <td>{{old('ob_from.'.$i)}}</td>
                                                        <td>{{old('ob_to.'.$i)}}</td>
                                                        <td>{{old('destination.'.$i)}}</td>
                                                        <td>{{old('purpose'.$i)}}</td>
                                                        <td><button type="button" class="btn btn-sm btn-danger" id="del_ob"><i class="fas fa-trash-alt"></i> Delete</button></td>
                                                        <input type="hidden" name="ob_date[]" value="{{old('ob_date.'.$i)}}" />
                                                        <input type="hidden" name="ob_from[]" value="{{old('ob_from.'.$i)}}" />
                                                        <input type="hidden" name="ob_to[]" value="{{old('ob_to.'.$i)}}" />
                                                        <input type="hidden" name="destination[]" value="{{old('destination.'.$i)}}" />
                                                        <input type="hidden" name="purpose[]" value="{{old('purpose.'.$i)}}" />
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
                                        <a href="/{{$reports_to->emp_photo}}" target="_blank"><img src="/{{$reports_to->emp_photo}}" class="img-fluid rounded-circle bg-dark" style="height:48px;"/></a> <span class="badge badge-secondary">{{$reports_to->full_name}}<br>{{$reports_to->emp_no}}</span>
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
                        <a href="{{ route('mytimekeeping').'#ob' }}" class="btn btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

