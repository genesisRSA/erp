@extends('layouts.main')

@section('title',ucwords($page))

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <h3><a href="{{ route('timekeeping', ['#shift']) }}" class="mr-3"><i class="fas fa-arrow-left"></i></a> Import Shift</h3>
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <form method="POST" action="{{ route('employeeshift.upload') }}" enctype="multipart/form-data">
                                            @csrf
                                        <label>Upload file (.csv) <sup class="text-danger">*</sup></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-upload"></i></span>
                                            </div>
                                            <input type="file" class="form-control" name="shift_file" id="shift_file" value="{{old('shift_file')}}" accept=".csv" required/>
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-success mr-2">Upload</button>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @if($shift_table)
                            <div class="row pt-3 mb-3">
                                <div class="col-md-12">
                                    <table id="shiftimport-dt" class="table table-striped table-bordered" style="width:100%;">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Row No.</th>
                                                <th>Employee</th>
                                                <th>Shift</th>
                                                <th>Date</th>
                                                <th>Day</th>
                                                <th>Time In</th>
                                                <th>Time Out</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($shift_table as $row)
                                                <tr class="{{ $row['has_error'] ? 'bg-danger text-white' : '' }}">
                                                    <td>{{$row["row_no"]}}</td>
                                                    <td><a href="/{{$row["emp_photo"] != 'N/A' ? $row["emp_photo"] : 'storage/profile/default-user.png'}}" target="_blank">
                                                            <img src="/{{$row["emp_photo"] != 'N/A'  ? $row["emp_photo"] : 'storage/profile/default-user.png'}}" class="img-fluid rounded-circle bg-dark" style="height:36px;"/>
                                                        </a> <span class="badge badge-secondary">{{$row["emp_name"]}}<br>{{$row["emp_no"]}}</span></td>
                                                    <td>{{$row["shift_desc"]}}</td>
                                                    <td>{{$row["shift_date"]}}</td>
                                                    <td>{{$row["shift_day"]}}</td>
                                                    <td>{{$row["time_in"]}}</td>
                                                    <td>{{$row["time_out"]}}</td>
                                                    <td>{{$row["remarks"]}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <!--End of Shift Information-->
                </div>
                <div class="container-fluid">
                    <div class="row mt-3 float-right">
                        <form method="POST" action="{{ route('employeeshift.importsubmit') }}" enctype="multipart/form-data">
                            @csrf
                            @if($shift_table)
                                @if($error_count == 0)
                                    <input type="hidden" name="file_path" value="{{$file_path}}"/>
                                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                                    <a href="{{ route('timekeeping',['#shift']) }}" class="btn btn-danger">Cancel</a>
                                @else
                                    <strong class="text-danger">Data contain(s) {{$error_count}} error(s).</strong>
                                @endif
                            @endif
                        </form>
                    </div>
                </div>
        </div>
    </div>
 @stop

