@extends('layouts.main')

@section('title',ucwords($page))

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <h3><a href="{{ url()->previous() }}#ob" class="mr-3"><i class="fas fa-arrow-left"></i></a> Official Business : {{$ob->ref_no}}</h3>
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
            <form method="POST" action="{{ route('ob.posted', $ob->id) }}" enctype="multipart/form-data">
                @csrf
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="ob-tab" data-toggle="tab" href="#ob" role="tab" aria-controls="ob" aria-selected="true">Official Business Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="true">Approval History</a>
                    </li>
                </ul>
                <div class="tab-content border border-top-0" id="myTabContent">
                    <!--OB Information-->
                    <div class="tab-pane fade show active" id="ob" role="tabpanel" aria-labelledby="ob-tab">
                        <div class="container-fluid">
                            <div class="row pt-3 mb-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Purpose</label>
                                        <input type="text" class="form-control" value="{{$ob->purpose}}" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>If "Others" please specify</label>
                                        <input type="text" class="form-control" name="others" id="others" value="{{$ob->others}}" placeholder="Others" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <input type="text" class="form-control" name="description" id="description" value="{{$ob->ob_desc}}" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Destination</label>
                                        <input type="text" class="form-control" name="destination" id="destination" value="{{$ob->destination}}" readonly/>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Date</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="date" class="form-control" name="ob_date" id="ob_date" value="{{$ob->ob_date}}" readonly/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>From (Hrs.)</label>
                                        <input type="number" class="form-control" name="ob_from" id="ob_from" value="{{$ob->ob_from}}" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Requestor</label><br>
                                        <a href="/{{$ob->filer_employee->emp_photo}}" target="_blank"><img src="/{{$ob->filer_employee->emp_photo}}" class="img-fluid rounded-circle bg-dark" style="height:48px;"/></a> <span class="badge badge-secondary">{{$ob->filer_employee->full_name}}<br>{{$ob->filer_employee->emp_no}}</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Date Filed</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" value="{{$ob->date_filed}}" readonly/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Status</label><br>
                                        @if($ob->status == 'Approved' || $ob->status == 'Posted')
                                            <button type="button" class="btn btn-success" style="width:100%;"><i class="fas fa-check-circle"></i>  {{$ob->status}}</button>
                                        @elseif($ob->status == 'Declined')
                                            <button type="button" class="btn btn-danger" style="width:100%;"><i class="fas fa-times-circle"></i> {{$ob->status}}</button>
                                        @else
                                            <button type="button" class="btn btn-warning" style="width:100%;"><i class="fas fa-hourglass-half"></i>  {{$ob->status}}</button>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Current Approver</label><br>
                                        @if($ob->approver_employee)
                                            <a href="/{{$ob->approver_employee->emp_photo}}" target="_blank"><img src="/{{$ob->approver_employee->emp_photo}}" class="img-fluid rounded-circle bg-dark" style="height:48px;"/></a> <span class="badge badge-secondary">{{$ob->approver_employee->full_name}}<br>{{$ob->approver_employee->emp_no}}</span>
                                        @else
                                            N/A
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End of OB Information-->
                    <!--OB History-->
                    <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                        <div class="container-fluid">
                            <h3 class="pt-3"></h3>
                            <table class="table table-striped table-bordered" style="width:100%;">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Transaction Date</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
                                        <th>Updated By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($history as $log)
                                        <tr>
                                            <td>{{date('M d, Y',strtotime($log->transaction_date))}}</td>
                                            <td>
                                                @if($log->status == 'Approved' || $log->status == 'Posted')
                                                    <button type="button" class="btn btn-success" style="width:100%;"><i class="fas fa-check-circle"></i>  {{$log->status}}</button>
                                                @elseif($log->status == 'Declined')
                                                    <button type="button" class="btn btn-danger" style="width:100%;"><i class="fas fa-times-circle"></i> {{$log->status}}</button>
                                                @else
                                                    <button type="button" class="btn btn-warning" style="width:100%;"><i class="fas fa-hourglass-half"></i>  {{$log->status}}</button>
                                                @endif
                                            </td>
                                            <td>{{$log->remarks}}</td>
                                            <td>
                                                @if($log->approved_by != 'N/A')
                                                  <a href="/{{App\Employee::where('emp_no','=',$log->approved_by)->first()->emp_photo}}" target="_blank"><img class="img-fluid rounded-circle bg-dark" src="/{{App\Employee::where('emp_no','=',$log->approved_by)->first()->emp_photo}}" style="height:48px;"/></a> <span class="badge badge-secondary">{{App\Employee::where('emp_no','=',$log->approved_by)->first()->full_name}}<br>{{App\Employee::where('emp_no','=',$log->approved_by)->first()->emp_no}}</span>
                                                @else

                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--End of ob History-->
                </div>
                <div class="container-fluid">
                        <div class="row mt-3 float-right">
                            @if($ob->status == 'Approved')
                            <button type="button" class="btn btn-success mr-2" data-toggle="modal" data-target="#postModal"><i class="fas fa-check-circle"></i> Post</button>
                            @endif
                        </div>
                    </div>
                    <!--MODALS-->
                    <div class="modal fade" id="postModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Post</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to post this official business?
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success" name="submit" value="post">Yes</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                                </div>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </div>
@stop

