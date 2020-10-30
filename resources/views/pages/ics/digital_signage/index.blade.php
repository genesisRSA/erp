@extends('layouts.main')

@section('title',ucwords($page))

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <h3 class="card-title">Digital Signage</h3>
            <hr>
            <p class="card-text">This module provides information about digital signage and display.</p>
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
                    <a class="nav-link active" id="my-tab" data-toggle="tab" href="#my" role="tab" aria-controls="leave" aria-selected="true">My Signages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="forapproval-tab" data-toggle="tab" href="#forapproval" role="tab" aria-controls="forapproval" aria-selected="forapproval">For Approval</a>
                </li>
            </ul>
            <div class="tab-content border border-top-0" id="myTabContent">
                <div class="tab-pane fade show active" id="my" role="tabpanel" aria-labelledby="my-tab">
                    <div class="container-fluid p-3">
                        <a href="{{route('signages.create')}}" class="btn btn-success mb-3"><i class="fas fa-plus-circle"></i> Create Signage</a>
                        <table id="signage-dt" class="table table-striped table-bordered w-100">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Preview</th>
                                    <th>Preview Vertical</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="forapproval" role="tabpanel" aria-labelledby="forapproval-tab">
                    <div class="container-fluid p-3">
                        <table id="forapproval-dt" class="table table-striped table-bordered w-100">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Type</th>
                                    <th>Department</th>
                                    <th>Requestor</th>
                                    <th>Preview</th>
                                    <th>Preview Vertical</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop