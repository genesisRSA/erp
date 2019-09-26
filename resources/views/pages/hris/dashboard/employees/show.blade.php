@extends('layouts.main')

@section('title',ucwords($page))

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <h3><a href="{{ route('employees.index') }}" class="mr-3"><i class="fas fa-arrow-left"></i></a><img src="/{{$employee->emp_photo}}" class="img-fluid rounded-circle bg-white border mr-2" style="height: 64px;"/> {{$employee->full_name}}</h3>
            <hr>
            <form method="POST" action="{{ route('employees.store') }}" enctype="multipart/form-data">
                @csrf
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">General Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="personal-tab" data-toggle="tab" href="#personal" role="tab" aria-controls="personal" aria-selected="false">Personal Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="leave-tab" data-toggle="tab" href="#leave" role="tab" aria-controls="leave" aria-selected="false">Leave Credits</a>
                    </li>
                </ul>
                <div class="tab-content border border-top-0" id="myTabContent">
                    <!--General Information-->
                    <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                        <div class="container-fluid">
                            <div class="row pt-3 mb-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Site</label>
                                        <input type="text" class="form-control" value="{{$employee->site->site_desc}}" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Bio Access ID </label>
                                        <input type="text" class="form-control" value="{{$employee->access_id}}" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Employee ID No.</label>
                                        <input type="text" class="form-control" value="{{$employee->emp_no}}" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Work Email</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="email-addon"><i class="fas fa-envelope-open-text"></i></span>
                                            </div>
                                            <input type="text" class="form-control" value="{{$employee->work_email}}" readonly/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Department</label>
                                        <input type="text" class="form-control" value="{{$employee->department->dept_desc}}" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Section</label>
                                        <input type="text" class="form-control" value="{{$employee->section->sect_desc}}" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Position</label>
                                        <input type="text" class="form-control" value="{{$employee->position}}" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Immediate Head</label>
                                        <br>
                                        <a href="/{{$reports_to ? $reports_to->emp_photo : 'storage/profile/1566540517.png'}}" target="_blank"><img src="/{{ $reports_to ? $reports_to->emp_photo : 'storage/profile/1566540517.png'}}" class="img-fluid rounded-circle bg-white border" style="height:48px;"/></a> <span class="badge badge-secondary">{{$reports_to ? $reports_to->full_name : 'N/A'}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Date Hired</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" value="{{date('m/d/Y', strtotime($employee->date_hired))}}" readonly/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Employment Category </label>
                                        <input type="text" class="form-control" value="{{$employee->emp_cat}}" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Date Regularized</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" value="{{date('m/d/Y', strtotime($employee->date_regularized))}}" readonly/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>HMO Detail</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                               @if($employee->is_hmo) 
                                                    <i class="fas fa-check-square"></i> 
                                               @else
                                                    <i class="fas fa-times-circle"></i>
                                               @endif
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" value="{{$employee->hmo_cardno}}" readonly/>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>SSS No.</label>
                                        <input type="text" class="form-control" value="{{$employee->sss_no}}" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Philhealth No.</label>
                                        <input type="text" class="form-control" value="{{$employee->phil_no}}" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Pagibig No.</label>
                                        <input type="text" class="form-control" value="{{$employee->pagibig_no}}" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>TIN No.</label>
                                        <input type="text" class="form-control" value="{{$employee->tin_no}}" readonly/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End of General Information-->
                    <!--Personal Information-->
                    <div class="tab-pane fade" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                        <div class="container-fluid">
                            <div class="row pt-3 mb-3">
                                <div class="col-md-3 border-right">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" class="form-control" value="{{$employee->emp_fname}}" readonly/>
                                    </div>
                                    <div class="form-group">
                                        <label>Middle Name</label>
                                        <input type="text" class="form-control" value="{{$employee->emp_mname}}" readonly/>
                                    </div>
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" class="form-control" value="{{$employee->emp_lname}}" readonly/>
                                    </div>
                                    <div class="form-group">
                                        <label>Name Suffix</label>
                                        <input type="text" class="form-control" value="{{$employee->emp_suffix}}" readonly/>
                                    </div>
                                    <div class="form-group">
                                        <label>Date of Birth</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" value="{{date('m/d/Y', strtotime($employee->dob))}}" readonly/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Gender</label>
                                        <input type="text" class="form-control" value="{{$employee->gender}}" readonly/>
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <input type="text" class="form-control" value="{{$employee->status}}" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <table class="table table-striped table-bordered" id="dep_table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th class="bg-primary" colspan="4">Dependencies</th>
                                            </tr>
                                            <tr>
                                                <th>Name</th>
                                                <th>Date of Birth</th>
                                                <th>Relationship</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($dep)
                                                @foreach ($dep as $item)
                                                    
                                                    <tr>
                                                        <td>{{$item->dep_name}}</td>
                                                        <td>{{$item->dep_dob}}</td>
                                                        <td>{{$item->dep_rel}}</td>
                                                    </td>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End of Personal Information-->
                    <!--Contact Information-->
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        <div class="container-fluid">
                            <div class="row pt-3 mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="current_address">Current Address</label>
                                        <textarea class="form-control" rows="3"  readonly>{{ $employee->current_address }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="home_address">Home Address</label>
                                        <textarea class="form-control" rows="3"  readonly>{{ $employee->home_address }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tel_no">Telephone No.</label>
                                        <input type="text" class="form-control" value="{{$employee->tel_no}}" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mobile_no">Mobile No.</label>
                                        <input type="text" class="form-control" value="{{$employee->mobile_no}}" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mobile_no">Personal Email</label>
                                        <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                <span class="input-group-text" id="email-addon"><i class="fas fa-envelope-open-text"></i></span>
                                            </div>
                                            <input type="text" class="form-control" value="{{$employee->personal_email}}" readonly/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="emergency_person">Emergency Contact Person</label>
                                        <input type="text" class="form-control" value="{{$employee->emergency_person}}" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="emergency_address">Emergency Contact Person's Address</label>
                                        <textarea class="form-control" rows="3"  readonly>{{ $employee->emergency_address }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="emergency_contact">Emergency Contact No.</label>
                                        <input type="text" class="form-control" value="{{$employee->emergency_contact}}" readonly/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End of Contact Information-->
                    
                    <!--Leave Credits-->
                    <div class="tab-pane fade" id="leave" role="tabpanel" aria-labelledby="leave-tab">
                        <div class="container-fluid">
                            <div class="row pt-3 mb-3">
                                <div class="col-md-3 border-right">
                                    <div class="form-group">
                                        <label>Sick Leave <sup class="text-danger">*</sup></label>
                                        <input type="number" class="form-control" min="0" name="sick_leave" value="{{ $leave_credits->sick_leave }}" readonly/>
                                    </div>
                                    <div class="form-group">
                                        <label>Admin Leave <sup class="text-danger">*</sup></label>
                                        <input type="number" class="form-control" min="0" name="admin_leave" value="{{ $leave_credits->admin_leave }}" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-3 border-right">
                                    <div class="form-group">
                                        <label>Vacation Leave <sup class="text-danger">*</sup></label>
                                        <input type="number" class="form-control" min="0" name="vacation_leave" value="{{ $leave_credits->vacation_leave }}" readonly/>
                                    </div>
                                    <div class="form-group">
                                        <label>Bereavement Leave <sup class="text-danger">*</sup></label>
                                        <input type="number" class="form-control" min="0" name="bereavement_leave" value="{{ $leave_credits->bereavement_leave }}" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-3 border-right">
                                    <div class="form-group">
                                        <label>Emergency Leave <sup class="text-danger">*</sup></label>
                                        <input type="number" class="form-control" min="0" name="emergency_leave" value="{{ $leave_credits->emergency_leave }}" readonly/>
                                    </div>
                                    <div class="form-group">
                                        <label>Birthday Leave <sup class="text-danger">*</sup></label>
                                        <input type="number" class="form-control" min="0" name="bday_leave" value="{{ $leave_credits->bday_leave }}" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Maternity Leave <sup class="text-danger">*</sup></label>
                                        <input type="number" class="form-control" min="0" name="maternity_leave" value="{{ $leave_credits->maternity_leave }}" readonly/>
                                    </div>
                                    <div class="form-group">
                                        <label>Paternity Leave <sup class="text-danger">*</sup></label>
                                        <input type="number" class="form-control" min="0" name="paternity_leave" value="{{ $leave_credits->paternity_leave }}" readonly/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End of Leave Credits-->
                </div>
            </form>
        </div>
    </div>
@stop