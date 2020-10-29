@extends('layouts.main')

@section('title',ucwords($page))

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <h3 class="card-title">Employees</h3>
            <hr>
            <p class="card-text">This module provides information about Employees record.</p>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <strong>Success,</strong> {{$message}}
                </div>
            @endif
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="aemployees-tab" data-toggle="tab" href="#aemployees" role="tab" aria-controls="aemployees" aria-selected="true">Active Employees</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="remployees-tab" data-toggle="tab" href="#remployees" role="tab" aria-controls="remployees" aria-selected="false">Resigned Employees</a>
                </li>
            </ul>
            <div class="tab-content border border-top-0" id="myTabContent">
                <!--ACTIVE EMPLOYEES-->
                <div class="tab-pane fade show active" id="aemployees" role="tabpanel" aria-labelledby="aemployees-tab">
                    <div class="container-fluid pt-3 mb-3">
                        <a href="{{ route('employees.create') }}" class="btn btn-success mb-3"><i class="fas fa-plus-circle"></i> Add Employee</a>
                        <table id="employee-dt" class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Site</th>
                                    <th>Section</th>
                                    <th>Position</th>
                                    <th>Employee</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!--END OF ACTIVE EMPLOYEES-->
                <!--RESIGNED EMPLOYEES-->
                <div class="tab-pane fade" id="remployees" role="tabpanel" aria-labelledby="remployees-tab">
                    <div class="container-fluid pt-3 mb-3">
                        <table id="resemployee-dt" class="table table-striped table-bordered w-100">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Site</th>
                                    <th>Section</th>
                                    <th>Position</th>
                                    <th>Employee</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!--END OF RESIGNED EMPLOYEES-->
            </div>
        </div>
    </div>
@stop

