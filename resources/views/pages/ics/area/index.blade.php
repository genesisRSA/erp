@extends('layouts.main')

@section('title',ucwords($page))

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <h3 class="card-title">Area Management</h3>
            <hr>
            <p class="card-text">This module provides information about area or location where inventory items will be located.</p>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <a href="create" class="btn btn-success mb-3"><i class="fas fa-plus-circle"></i> Add Area</a>
            <table id="area-dt" class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Area Type</th>
                        <th>Code</th>
                        <th>Area Name</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@stop