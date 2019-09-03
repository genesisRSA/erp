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
            <a href="{{ route('employees.create') }}" class="btn btn-success mb-3"><i class="fas fa-plus-circle"></i> Add Employee</a>
            <table id="employee-dt" class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Site</th>
                        <th>Department</th>
                        <th>Section</th>
                        <th>Employee ID No.</th>
                        <th>Photo</th>
                        <th>Employee Name</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@stop

