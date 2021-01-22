@extends('layouts.main')

@section('title',ucwords($page))

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <h3><a href="{{ route('mytimekeeping',['#otapproval']) }}" class="mr-3"><i class="fas fa-arrow-left"></i></a> Overtime Approval : {{$ot->ref_no}}</h3>
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
            <form method="POST" action="{{ route('ot.update', $ot->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="ot-tab" data-toggle="tab" href="#ot" role="tab" aria-controls="ot" aria-selected="true">Overtime Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="true">Approval History</a>
                    </li>
                </ul>
                <div class="tab-content border border-top-0" id="myTabContent">
                    <!--OT Information-->
                    <div class="tab-pane fade show active" id="ot" role="tabpanel" aria-labelledby="ot-tab">
                        <div class="container-fluid">
                            <div class="row pt-3 mb-3">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered" id="ot_table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th class="bg-primary" colspan="5">Overtime Details</th>
                                            </tr>
                                            <tr>
                                                <th>Employee</th>
                                                <th>OT Date</th>
                                                <th>OT Duration From</th>
                                                <th>OT Duration To</th>
                                                <th>Reason for Rendering OT</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($ot_details)
                                                @foreach ($ot_details as $item)
                                                    <tr>
                                                        <td>@php $emp = App\Employee::where('emp_no',$item->emp_no)->first() @endphp
                                                            <img src="/{{$emp->emp_photo}}" class="img-fluid rounded-circle bg-dark" style="height:48px;"/></a> <span class="badge badge-secondary">{{$emp->full_name}}<br>{{$emp->emp_no}}
                                                        </td>
                                                        <td>{{$item->ot_date}}</td>
                                                        <td>{{$item->ot_start }}</td>
                                                        <td>{{$item->ot_end }}</td>
                                                        <td>{{$item->reason}}</td>
                                                    </td>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Requestor</label><br>
                                        <a href="/{{$ot->filer_employee->emp_photo}}" target="_blank"><img src="/{{$ot->filer_employee->emp_photo}}" class="img-fluid rounded-circle bg-dark" style="height:48px;"/></a> <span class="badge badge-secondary">{{$ot->filer_employee->full_name}}<br>{{$ot->filer_employee->emp_no}}</span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Date Filed</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" value="{{$ot->date_filed}}" readonly/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Status</label><br>
                                        <button type="button" class="btn btn-warning" style="width:100%;"><i class="fas fa-hourglass-half"></i> {{$ot->status}}</button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Remarks <sup class="text-danger">*</sup></label>
                                        <textarea class="form-control @if($errors->has('remarks')) is-invalid @endif" name="remarks" id="remarks" rows="3" placeholder="Enter Remarks">{{old('remarks')}}</textarea>
                                        <div class="invalid-feedback">
                                            {{ $errors->first('remarks') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End of OT Information-->
                    <!--OT History-->
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
                    <!--End of OT History-->
                </div>
                <div class="container-fluid">
                    <div class="row mt-3 float-right">
                        <button type="button" class="btn btn-success mr-2" data-toggle="modal" data-target="#approveModal"><i class="fas fa-check-circle"></i> Approve</button>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#declineModal"><i class="fas fa-times-circle"></i> Decline</button>
                    </div>
                </div>
                <!--MODALS-->
                <div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Approve Overtime</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to approve this overtime?
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success" name="submit" value="approve">Yes</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="declineModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Decline Overtime</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to decline this overtime?
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success" name="submit" value="decline">Yes</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

