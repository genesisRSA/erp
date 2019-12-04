@extends('layouts.main')

@section('title',ucwords($page))

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <h3><a href="{{ route('mytimekeeping').'#ot' }}" class="mr-3"><i class="fas fa-arrow-left"></i></a> File Overtime</h3>
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
            <form method="POST" action="{{ route('ot.store') }}" enctype="multipart/form-data">
                @csrf
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#ot" role="tab" aria-controls="ot" aria-selected="true">Overtime Information</a>
                    </li>
                </ul>
                <div class="tab-content border border-top-0" id="myTabContent">
                    <!--OT Information-->
                    <div class="tab-pane fade show active" id="ot" role="tabpanel" aria-labelledby="ot-tab">
                        <div class="container-fluid">
                            <div class="row pt-3 mb-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>OT Date <sup class="text-danger">*</sup></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="date" class="form-control" id="ot_date" value="{{old('ot_date') ? old('ot_date') : date('Y-m-d')}}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>OT Duration From (Time) <sup class="text-danger">*</sup></label>
                                        <input type="time" class="form-control" id="ot_from" value="{{old('ot_from')}}"/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>OT Duration To (Time) <sup class="text-danger">*</sup></label>
                                        <input type="time" class="form-control" id="ot_to" value="{{old('ot_to')}}"/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Reason for Rendering OT <sup class="text-danger">*</sup></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="reason" value="{{old('reason')}}" placeholder="Enter Reason"/>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-sm btn-success" id="add_ot"><i class="fas fa-plus-circle"></i> Add OT</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered" id="ot_table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th class="bg-primary" colspan="5">Overtime Details</th>
                                            </tr>
                                            <tr>
                                                <th>OT Date</th>
                                                <th>OT Duration From</th>
                                                <th>OT Duration To</th>
                                                <th>Reason for Rendering OT</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(old('ot_date'))
                                                @for ($i = 0; $i < count(old('ot_date')); $i++)
                                                    <tr>
                                                        <td>{{old('ot_date.'.$i)}}</td>
                                                        <td>{{old('ot_from.'.$i)}}</td>
                                                        <td>{{old('ot_to.'.$i)}}</td>
                                                        <td>{{old('reason.'.$i)}}</td>
                                                        <td><button type="button" class="btn btn-sm btn-danger" id="del_dep"><i class="fas fa-trash-alt"></i> Delete</button></td>
                                                        <input type="hidden" name="ot_date[]" value="{{old('ot_date.'.$i)}}" />
                                                        <input type="hidden" name="ot_from[]" value="{{old('ot_from.'.$i)}}" />
                                                        <input type="hidden" name="ot_to[]" value="{{old('ot_to.'.$i)}}" />
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
                                        <a href="/{{$reports_to->emp_photo}}" target="_blank"><img src="/{{$reports_to->emp_photo}}" class="img-fluid rounded-circle bg-dark" style="height:48px;"/></a> <span class="badge badge-secondary">{{$reports_to->full_name}}<br>{{$reports_to->emp_no}}</span>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <!--End of OT Information-->
                </div>
                <div class="container-fluid">
                    <div class="row mt-3 float-right">
                        <button type="submit" class="btn btn-success mr-2">Submit</button>
                        <a href="{{ route('mytimekeeping').'#ot' }}" class="btn btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

