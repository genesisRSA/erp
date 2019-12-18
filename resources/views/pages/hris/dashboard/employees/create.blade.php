@extends('layouts.main')

@section('title',ucwords($page))

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <h3><a href="{{ route('employees.index') }}" class="mr-3"><i class="fas fa-arrow-left"></i></a> Add Employee</h3>
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
                        <a class="nav-link" id="medical-tab" data-toggle="tab" href="#medical" role="tab" aria-controls="medical" aria-selected="false">Medical Information</a>
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
                                <div class="col-md-9">
                                    <label>Employee Image <sup class="text-danger">*</sup></label>
                                    <input type="file" class="form-control {{ $errors->has('emp_img') ? 'is-invalid' : '' }}" name="emp_img" id="emp_img" placeholder="Enter Employee ID" accept=".jpg,.png" />
                                    <div class="invalid-feedback">
                                        {{ $errors->first('emp_img') }}
                                    </div>
                                </div>
                                <div class="col-md-3 text-center">
                                    <img src="{{url('/images/default-user.png')}}" class="img-thumbnail" id="emp_img_preview" style="height:100px;width:100px;" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Site <sup class="text-danger">*</sup></label>
                                        <select class="form-control {{ $errors->has('site_code') ? 'is-invalid' : '' }}" name="site_code" id="site_code" >
                                            <option value="" disabled selected>Choose Site...</option>
                                            
                                            @foreach ($sites as $s)
                                                <option value="{{$s->site_code}}" {{old('site_code') == $s->site_code ? 'selected' : ''}}>{{$s->site_desc}}</option>
                                            @endforeach

                                        </select>
                                        <div class="invalid-feedback">
                                            {{ $errors->first('site_code') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Bio Access ID  <sup class="text-danger">*</sup></label>
                                        <select class="form-control {{ $errors->has('access_id') ? 'is-invalid' : '' }}" name="access_id" id="access_id" >
                                            <option value="" disabled selected>Choose Bio Access ID...</option>

                                            @foreach ($access_id as $access)
                                                <option value="{{$access->access_id}}" {{ old('access_id')==$access->access_id ? 'selected' : '' }}> {{$access->emp_name}} (ID : {{$access->access_id}}) </option>
                                            @endforeach

                                        </select>
                                        <div class="invalid-feedback">
                                            {{ $errors->first('access_id') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Employee ID No. <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control {{ $errors->has('emp_no') ? 'is-invalid' : '' }}" value="{{ old('emp_no')}}" name="emp_no" placeholder="Enter Employee ID" />
                                        <div class="invalid-feedback">
                                            {{ $errors->first('emp_no') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Work Email <sup class="text-danger">*</sup></label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control {{ $errors->has('work_email') ? 'is-invalid' : '' }}" name="work_email" placeholder="Work Email" aria-label="Employee Email" aria-describedby="email-addon" value="{{ old('work_email') }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="email-addon">{{ old('email_suffix') ? old('email_suffix') : '@' }}</span>
                                            </div>
                                            <input type="hidden" name="email_suffix" id="email_suffix" value="{{ old('email_suffix') }}"/>
                                            <div class="invalid-feedback">
                                                {{ $errors->first('work_email') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Department <sup class="text-danger">*</sup></label>
                                        <select class="form-control {{ $errors->has('dept_code') ? 'is-invalid' : '' }}" name="dept_code" id="dept_code" >
                                            <option value="" disabled selected>Choose Department...</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            {{ $errors->first('dept_code') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Section <sup class="text-danger">*</sup></label>
                                        <select class="form-control {{ $errors->has('sect_code') ? 'is-invalid' : '' }}" name="sect_code" id="sect_code" >
                                            <option value="" disabled selected>Choose Section...</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            {{ $errors->first('sect_code') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Position <sup class="text-danger">*</sup></label>
                                        <select class="form-control {{ $errors->has('position') ? 'is-invalid' : '' }}" name="position" id="position" >
                                            <option value="" disabled selected>Choose Position...</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            {{ $errors->first('position') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Immediate Head</label>
                                        <select class="form-control {{ $errors->has('reports_to') ? 'is-invalid' : '' }}" name="reports_to" id="reports_to">
                                            <option value="" disabled selected>Choose Immediate Head...</option>
                                            @foreach ($employees as $e)
                                                <option value="{{$e->emp_no}}" {{old('reports_to') == $e->emp_no ? 'selected' : ''}}>{{$e->full_name}}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            {{ $errors->first('reports_to') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Date Hired <sup class="text-danger">*</sup></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="date" class="form-control" name="date_hired" id="date_hired" value="{{old('date_hired') ? old('date_hired') : date('Y-m-d')}}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Employment Category  <sup class="text-danger">*</sup></label>
                                        <select class="form-control {{ $errors->has('emp_cat') ? 'is-invalid' : '' }}" name="emp_cat" id="emp_cat" >
                                            <option value="" disabled selected>Choose Category...</option>
                                            <option {{old('emp_cat') == 'Contractual'  ? 'selected' : ''}}>Contractual</option>
                                            <option {{old('emp_cat') == 'Probationary'  ? 'selected' : ''}}>Probationary</option>
                                            <option {{old('emp_cat') == 'Regular'  ? 'selected' : ''}}>Regular</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            {{ $errors->first('emp_cat') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Date Regularized</label>
                                        <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                </div>
                                            <input type="date" class="form-control" name="date_regularized" id="date_regularized" placeholder="Enter Date Regularized" value="{{old('emp_cat') == 'Regular'  ? old('date_regularized') : '1990-01-01'}}" {{old('emp_cat') == 'Regular'  ? '' : 'readonly'}}/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>HMO Detail</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                            <input type="checkbox" name="is_hmo" id="is_hmo" aria-label="is_hmo" {{old('is_hmo')  ? 'checked' : ''}}>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" name="hmo_cardno" id="hmo_cardno" placeholder="HMO Card No." value="{{old('is_hmo')  ? old('hmo_cardno') : ''}}" {{old('is_hmo')  ? 'checked' : 'readonly'}}>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>SSS No. <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control {{ $errors->has('sss_no') ? 'is-invalid' : '' }}" name="sss_no" id="sss_no" value="{{ old('sss_no') }}" placeholder="e.g 00-1234567-8" />
                                        <div class="invalid-feedback">
                                            {{ $errors->first('sss_no') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Philhealth No. <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control {{ $errors->has('phil_no') ? 'is-invalid' : '' }}" name="phil_no" id="phil_no" value="{{ old('phil_no') }}" placeholder="e.g 1234-5678-9123" />
                                        <div class="invalid-feedback">
                                            {{ $errors->first('phil_no') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Pagibig No. <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control {{ $errors->has('pagibig_no') ? 'is-invalid' : '' }}" name="pagibig_no" id="pagibig_no" value="{{ old('pagibig_no') }}" placeholder="e.g 1234-5678-9123" />
                                        <div class="invalid-feedback">
                                            {{ $errors->first('pagibig_no') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>TIN No. <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control {{ $errors->has('tin_no') ? 'is-invalid' : '' }}" name="tin_no" id="tin_no" value="{{ old('tin_no') }}" placeholder="e.g 1234-5678-9123-4567" />
                                        <div class="invalid-feedback">
                                            {{ $errors->first('tin_no') }}
                                        </div>
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
                                        <label>First Name <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control {{ $errors->has('emp_fname') ? 'is-invalid' : '' }}" name="emp_fname" id="emp_fname" value="{{ old('emp_fname') }}" placeholder="Enter First Name" />
                                        <div class="invalid-feedback">
                                            {{ $errors->first('emp_fname') }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Middle Name</label>
                                        <input type="text" class="form-control" name="emp_mname" id="emp_mname" value="{{ old('emp_mname') }}" placeholder="Enter Middle Name"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Last Name <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control {{ $errors->has('emp_fname') ? 'is-invalid' : '' }}" name="emp_lname" id="emp_lname" value="{{ old('emp_lname') }}" placeholder="Enter Last Name" />
                                        <div class="invalid-feedback">
                                            {{ $errors->first('emp_lname') }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Name Suffix</label>
                                        <input type="text" class="form-control" name="emp_suffix" id="emp_suffix" value="{{ old('emp_suffix') }}" placeholder="Enter Name Suffix"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Date of Birth <sup class="text-danger">*</sup></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="date" class="form-control" value="{{ old('dob') ? old('dob') : '1990-01-01'}}" name="dob" id="dob" placeholder="Enter Date of Birth" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Gender <sup class="text-danger">*</sup></label>
                                        <select class="form-control" name="gender" id="gender" >
                                            <option {{ old('gender') == 'Female' ? 'selected' : ''}}>Female</option>
                                            <option {{ old('gender') == 'Male' ? 'selected' : ''}}>Male</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Status <sup class="text-danger">*</sup></label>
                                        <select class="form-control" name="status" id="status" >
                                            <option {{ old('status') == 'Single' ? 'selected' : ''}}>Single</option>
                                            <option {{ old('status') == 'Married' ? 'selected' : ''}}>Married</option>
                                            <option {{ old('status') == 'Widowed' ? 'selected' : ''}}>Widowed</option>
                                            <option {{ old('status') == 'Separated' ? 'selected' : ''}}>Separated</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Name of Dependency</label>
                                                <input type="text" class="form-control" id="dep_name" placeholder="Enter Name of Dependency"/>
                                                <div class="invalid-feedback">
                                                    The Name of Dependency field is required.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Date of Birth</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                    </div>
                                                    <input type="date" class="form-control" value="1990-01-01" id="dep_dob" placeholder="Enter Date of Birth" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Relationship</label>
                                                <div class="input-group">
                                                    <select class="form-control" id="dep_rel">
                                                        <option>Mother</option>
                                                        <option>Father</option>
                                                        <option>Brother</option>
                                                        <option>Sister</option>
                                                        <option>Spouse</option>
                                                        <option>Daughter</option>
                                                        <option>Son</option>
                                                    </select>
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-sm btn-success" id="add_dep"><i class="fas fa-plus-circle"></i> Add Dependency</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table table-striped table-bordered" id="dep_table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th class="bg-primary" colspan="4">Dependencies</th>
                                            </tr>
                                            <tr>
                                                <th>Name</th>
                                                <th>Date of Birth</th>
                                                <th>Relationship</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(old('dep_name'))
                                                @for ($i = 0; $i < count(old('dep_name')); $i++)
                                                    <tr>
                                                        <td>{{old('dep_name.'.$i)}}</td>
                                                        <td>{{old('dep_dob.'.$i)}}</td>
                                                        <td>{{old('dep_rel.'.$i)}}</td>
                                                        <td><button type="button" class="btn btn-sm btn-danger" id="del_dep"><i class="fas fa-trash-alt"></i> Delete</button></td>
                                                        <input type="hidden" name="dep_name[]" value="{{old('dep_name.'.$i)}}" />
                                                        <input type="hidden" name="dep_dob[]" value="{{old('dep_dob.'.$i)}}" />
                                                        <input type="hidden" name="dep_rel[]" value="{{old('dep_rel.'.$i)}}" />
                                                    </td>
                                                @endfor
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
                                        <label for="current_address">Current Address <sup class="text-danger">*</sup></label>
                                        <textarea class="form-control {{ $errors->has('current_address') ? 'is-invalid' : '' }}" name="current_address" id="current_address" rows="3"  placeholder="Enter Current Address">{{ old('current_address') }}</textarea>
                                        <div class="invalid-feedback">
                                            {{ $errors->first('current_address') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="home_address">Home Address <sup class="text-danger">*</sup></label>
                                        <textarea class="form-control {{ $errors->has('home_address') ? 'is-invalid' : '' }}" name="home_address" id="home_address" rows="3"  placeholder="Enter Home Address">{{ old('home_address') }}</textarea>
                                        <div class="invalid-feedback">
                                            {{ $errors->first('home_address') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tel_no">Telephone No.</label>
                                        <input type="text" class="form-control" name="tel_no" id="tel_no" value="{{ old('tel_no') }}" placeholder="Enter Telephone No."/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mobile_no">Mobile No.</label>
                                        <input type="text" class="form-control" name="mobile_no" id="mobile_no" value="{{ old('mobile_no') }}" placeholder="Enter Mobile No."/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="personal_email">Personal Email</label>
                                        <input type="text" class="form-control" name="personal_email" id="personal_email" value="{{ old('personal_email') }}"  placeholder="Enter Personal Email"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="emergency_person">Emergency Contact Person <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control {{ $errors->has('emergency_person') ? 'is-invalid' : '' }}" name="emergency_person" id="emergency_person" value="{{ old('emergency_person') }}"  placeholder="Enter Emergency Contact Person"/>
                                        <div class="invalid-feedback">
                                            {{ $errors->first('emergency_person') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="emergency_address">Emergency Contact Person's Address <sup class="text-danger">*</sup></label>
                                        <textarea class="form-control {{ $errors->has('emergency_address') ? 'is-invalid' : '' }}" name="emergency_address" id="emergency_address" rows="3"  placeholder="Enter Emergency Contact Person Address">{{ old('emergency_address') }}</textarea>
                                        <div class="invalid-feedback">
                                            {{ $errors->first('emergency_address') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="emergency_contact">Emergency Contact No. <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control {{ $errors->has('emergency_contact') ? 'is-invalid' : '' }}" name="emergency_contact" id="emergency_contact" value="{{ old('emergency_contact') }}" placeholder="Enter Emergency Contact No."/>
                                        <div class="invalid-feedback">
                                            {{ $errors->first('emergency_contact') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End of Contact Information-->
                    <!--Medical Information-->
                    <div class="tab-pane fade" id="medical" role="tabpanel" aria-labelledby="medical-tab">
                        <div class="container-fluid">
                            <div class="row pt-3 mb-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="blood_type">Blood Type <sup class="text-danger">*</sup></label>
                                        <select class="form-control" name="blood_type" id="blood_type" >
                                            <option {{ old('blood_type') == 'O-' ? 'selected' : ''}}>O-</option>
                                            <option {{ old('blood_type') == 'O+' ? 'selected' : ''}}>O+</option>
                                            <option {{ old('blood_type') == 'A-' ? 'selected' : ''}}>A-</option>
                                            <option {{ old('blood_type') == 'A+' ? 'selected' : ''}}>A+</option>
                                            <option {{ old('blood_type') == 'B-' ? 'selected' : ''}}>B-</option>
                                            <option {{ old('blood_type') == 'B+' ? 'selected' : ''}}>B+</option>
                                            <option {{ old('blood_type') == 'AB-' ? 'selected' : ''}}>AB-</option>
                                            <option {{ old('blood_type') == 'AB+' ? 'selected' : ''}}>AB+</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            {{ $errors->first('blood_type') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="emp_height">Height (cm)<sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control {{ $errors->has('emp_height') ? 'is-invalid' : '' }}" name="emp_height" id="emp_height" placeholder="Enter Height e.g 162.56 cm" value="{{ old('emp_height') }}" />
                                        <div class="invalid-feedback">
                                            {{ $errors->first('emp_height') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="emp_weight">Weight (lbs)<sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control {{ $errors->has('emp_weight') ? 'is-invalid' : '' }}" name="emp_weight" id="emp_weight" placeholder="Enter Weight e.g 121.254 lbs" value="{{ old('emp_weight') }}" />
                                        <div class="invalid-feedback">
                                            {{ $errors->first('emp_weight') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="medical_issues">Medical Issues<sup class="text-danger">*</sup></label>
                                        <textarea class="form-control {{ $errors->has('medical_issues') ? 'is-invalid' : '' }}" name="medical_issues" id="medical_issues" rows="3" placeholder="Enter Medical Issues">{{ old('medical_issues') }}</textarea>
                                        <div class="invalid-feedback">
                                            {{ $errors->first('medical_issues') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="birth_mark">Birth Mark</label>
                                        <input type="text" class="form-control {{ $errors->has('birth_mark') ? 'is-invalid' : '' }}" name="birth_mark" id="birth_mark" placeholder="Enter Place of Birth Mark" value="{{ old('birth_mark') }}" />
                                        <div class="invalid-feedback">
                                            {{ $errors->first('birth_mark') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End of Medical Information-->
                    <!--Leave Credits-->
                    <div class="tab-pane fade" id="leave" role="tabpanel" aria-labelledby="leave-tab">
                        <div class="container-fluid">
                            <div class="row pt-3 mb-3">
                                <div class="col-md-3 border-right">
                                    <div class="form-group">
                                        <label>Sick Leave <sup class="text-danger">*</sup></label>
                                        <input type="number" step=".01" class="form-control" min="0" name="sick_leave" value="{{ old('sick_leave') ? old('sick_leave') : 0}}"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Admin Leave <sup class="text-danger">*</sup></label>
                                        <input type="number" step=".01" class="form-control" min="0" name="admin_leave" value="{{ old('admin_leave') ? old('admin_leave') : 0}}"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Special Leave for Women<sup class="text-danger">*</sup></label>
                                        <input type="number" step=".01" class="form-control" min="0" name="special_leave" value="{{ old('special_leave') ? old('special_leave') : 0}}"/>
                                    </div>
                                </div>
                                <div class="col-md-3 border-right">
                                    <div class="form-group">
                                        <label>Vacation Leave <sup class="text-danger">*</sup></label>
                                        <input type="number" step=".01" class="form-control" min="0" name="vacation_leave" value="{{ old('vacation_leave') ? old('vacation_leave') : 0}}"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Bereavement Leave <sup class="text-danger">*</sup></label>
                                        <input type="number" step=".01" class="form-control" min="0" name="bereavement_leave" value="{{ old('bereavement_leave') ? old('bereavement_leave') : 0}}"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Leave for Abused Women <sup class="text-danger">*</sup></label>
                                        <input type="number" step=".01" class="form-control" min="0" name="abused_leave" value="{{ old('abused_leave') ? old('abused_leave') : 0}}"/>
                                    </div>
                                </div>
                                <div class="col-md-3 border-right">
                                    <div class="form-group">
                                        <label>Solo Parent Leave <sup class="text-danger">*</sup></label>
                                        <input type="number" step=".01" class="form-control" min="0" name="solo_parent_leave" value="{{ old('solo_parent_leave') ? old('solo_parent_leave') : 0}}"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Birthday Leave <sup class="text-danger">*</sup></label>
                                        <input type="number" step=".01" class="form-control" min="0" name="bday_leave" value="{{ old('bday_leave') ? old('bday_leave') : 0}}"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Expanded Maternity Leave <sup class="text-danger">*</sup></label>
                                        <input type="number" step=".01" class="form-control" min="0" name="expanded_leave" value="{{ old('expanded_leave') ? old('expanded_leave') : 0}}"/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Maternity Leave <sup class="text-danger">*</sup></label>
                                        <input type="number" step=".01" class="form-control" min="0" name="maternity_leave" id="maternity_leave" value="{{ old('maternity_leave') ? old('maternity_leave') : 0}}"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Paternity Leave <sup class="text-danger">*</sup></label>
                                        <input type="number" step=".01" class="form-control" min="0" name="paternity_leave" id="paternity_leave" value="{{ old('paternity_leave') ? old('paternity_leave') : 0}}"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End of Leave Credits-->
                </div>
                <div class="container-fluid">
                    <div class="row mt-3 float-right">
                        <button type="submit" class="btn btn-success mr-2">Save</button>
                        <a href="{{ route('employees.index') }}" class="btn btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

