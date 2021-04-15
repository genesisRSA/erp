@extends('layouts.resmain')
<style>
   textarea.materialize-textarea
        {
            height: 20% !important; 
        }
</style>

@section('content')
  <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h4 class="title"><span class="grey-text darken-4">Document Control Centre<i class="material-icons">arrow_forward_ios</i></span><span class="grey-text darken-4">Procedures<i class="material-icons">arrow_forward_ios</i></span>Procedure Approval</h4>
    </div>
  </div>
 
  <div class="m-3 main-content">  
    <ul id="procedure_tab" class="tabs tabs-fixed-width tab-demo z-depth-1">
      <li class="tab col s12 m4 l4"><a class="active" href="#procedure">Procedure Details</a></li>
      <li class="tab col s12 m4 l4"><a href="#signatories">signatories</a></li>
    </ul>
      <div class="card" style="margin-top: 0px">
        <div class="card-body">
          <form method="POST" action="{{route('procedure.approve')}}" enctype="multipart/form-data">
          {{-- <form> --}}
            @csrf
            <div class="row">
              {{-- hidden items --}}
              <input type="hidden" name="id" id="id_app" value="{{$procedures->id}}"/>
              <input type="hidden" name="seq" id="seq_app" value="{{$procedures->current_sequence}}"/>
              <input type="hidden" name="appid" id="appid_app" value="{{$procedures->current_approver}}"/>

              @if($procedures->revision_no!=0)
              <input type="hidden" id="rev_dpr_code_h" name="dpr_code_h"  class="grey lighten-5" value="{{$procedures_h->dpr_code}}"/>
              <input type="hidden" id="rev_requested_date_h" name="requested_date_h" value="{{$procedures_h->requested_date}}"/>
              <input type="hidden" id="rev_document_no_h" name="document_no_h" value="{{$procedures_h->document_no}}"  placeholder=" "/>
              <input type="hidden" id="rev_revision_no_h" name="revision_no_h" value="{{$procedures_h->revision_no}}" placeholder=" "/>
              <input type="hidden" id="rev_change_description_h" name="change_description_h" value="{{$procedures_h->change_description}}"/>
              <input type="hidden" id="rev_change_reason_h" name="change_reason_h" value="{{$procedures_h->change_reason}}"/>
              <input type="hidden" id="file_name_h" name="file_name_h" value="{{$procedures_h->file_name}}" />
              <input type="hidden" id="created_by_h" name="created_by_h" value="{{$procedures_h->created_by}}" />
              <input type="hidden" id="reviewed_by_h" name="reviewed_by_h" value="{{$procedures_h->reviewed_by}}" />
              <input type="hidden" id="approved_by_h" name="approved_by_h" value="{{$procedures_h->approved_by}}" />
              <input type="hidden" id="status_h" name="status_h" value="{{$procedures_h->status}}"/>
              @endif

              <input type="hidden" id="created_by" name="created_by" value="{{$procedures->created_by}}" />
              <input type="hidden" id="file_name" name="file_name" value="{{$procedures->file_name}}" />
              <input type="hidden" id="status" name="status">

              {{-- hidden items --}}
              <div id="procedure" name="procedure">
                <br>
                <div class="row">
                  <div class="col s12 m12 l12">
                      <div class="col s12 m12 l12">
                          <div class="input-field col s12 m3 l3">
                              <input type="text" id="rev_dpr_code" name="dpr_code"  class="grey lighten-5" value="{{$procedures->dpr_code}}" readonly/>
                              <label for="dpr_code">DPR No.<sup class="red-text"></sup></label>
                          </div>
                          <div class="input-field col s12 m3 l3">
                              <input type="text" id="rev_requested_date" name="requested_date" class="grey lighten-5" value="{{$procedures->requested_date}}" readonly/>
                              <label for="requested_date">Date Requested<sup class="red-text"></sup></label>
                          </div> 
                          <div class="input-field col s12 m6 l6">
                            <input type="text" id="rev_requested_by" name="requested_by" class="grey lighten-5" value="{{$employee->full_name}}" readonly/>
                            <label for="requested_by">Requested By<sup class="red-text"></sup></label>
                          </div> 
                      </div>
                      
                      <div class="col s12 m12 l12">
                          <div class="input-field col s12 m6 l6">
                              <input type="text" id="rev_document_title" name="document_title" value="{{$procedures->document_title}}"  placeholder=" " readonly/>
                              <label for="document_title">Document Title<sup class="red-text">*</sup></label>
                          </div>
                          <div class="input-field col s12 m3 l3">
                              <input type="text" id="rev_document_no" name="document_no"  value="{{$procedures->document_no}}"  placeholder=" " readonly/>
                              <label for="document_no">Document No.<sup class="red-text"></sup></label>
                          </div>
                          <div class="input-field col s12 m3 l3">
                              <input type="text" id="rev_revision_no" name="revision_no" value="{{$procedures->revision_no}}" placeholder=" " readonly/>
                              <label for="revision_no">Revision No.<sup class="red-text"></sup></label>
                          </div>
                      </div>

                      <div class="col s12 m12 l12">
                          <div class="input-field col s12 m6 l6">
                              <textarea id="rev_change_description" name="change_description" class="materialize-textarea" placeholder="Some text here.." style="padding-bottom: 0px; border-bottom-width: 2px; margin-bottom: 0px;" readonly>{{$procedures->change_description}}</textarea>
                              <label for="change_description">Description of Change(s)<sup class="red-text">*</sup></label>
                          </div>

                          <div class="input-field col s12 m6 l6">
                              <textarea id="rev_change_reason" name="change_reason" class="materialize-textarea"  placeholder="Some text here.." style="padding-bottom: 0px; border-bottom-width: 2px; margin-bottom: 0px;" readonly>{{$procedures->change_reason}}</textarea>
                              <label for="change_reason">Reason for Preparation / Revision<sup class="red-text">*</sup></label>
                          </div>
                      </div>
                      
                      <div class="col s12 m12 l12">


                        <h6 style="padding: 10px; padding-top: 20px; padding-left: 10px; padding-right: 10px; margin-bottom: 10px;background-color:#0d47a1" class="white-text"><b>Procedure Attachment(s)</b></h6>  
                        <div class="col s12 m12 l12">

                          </div>
                          <div class="row">
                            <br>
                            <div style="width:93%; 
                                        height:50%; 
                                        z-index: 10; 
                                        opacity:0.15;
                                        position:absolute; 
                                        text-align:center;
                                        line-height:400px;
                                        font-size:130px; 
                                        color:blue;">
                                &nbspRSA PROPERTY
                                &nbspRSA PROPERTY
                              </div>
                          </div>
            
                            <embed
                                src="{{ action('ProceduresController@getDocument', ['id'=> $idx, 'stat' => $procedures->status, 'loc' => $loc]) }}#toolbar=0"
                                style="width:100%; 
                                      height:130%; 
                                      " type="application/pdf"
                                id = "pdf_file"
                                frameborder="1"
                                > 
                          </div>
            
                          <div class="col s12 m12 l12">
                            <h6 style="padding: 10px; padding-top: 20px; padding-left: 10px; padding-right: 10px;  margin-top: 20px; background-color:#0d47a1" class="white-text"><b>Revision History</b></h6>  
                          </div>
            
                          <div class="col s12 m12 l12">
                            <div class="card" style="margin-top: 0px">
                              <div class="card-content">
                                <table class="responsive-table highlight" id="revisions-dt" style="width: 100%">
                                  <thead>
                                    <tr>
                                        <th>ID</th> 
                                        <th>Document No.</th>
                                        <th>Document Title</th>
                                        <th>DPR No.</th>
                                        <th>Revision No.</th>
                                        <th>Status</th>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                            </div>
                          </div>
                      </div>
                  </div>
                </div>
              </div>
          
              <div id="signatories" name="signatories" class="row">
  
                  <div class="row">
                    <div class="col s12 m12 l12" style="
                    padding-right: 30px;
                    padding-left: 30px;
                ">
                      <div class="card">
                        <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; background-color:#0d47a1" class="white-text"><b>Current Signatories</b></h6><hr style="margin: 0px">
                        <div class="card-content" style="padding: 10px; padding-top: 0px">
                          <table class="highlight" id="approver-dt">
                            <thead>
                              <tr>
                                  <th>Sequence</th> 
                                  <th>Approver ID</th> 
                                  <th>Approver Name</th> 
                              </tr>
                            </thead>
                            <tbody></tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col s12 m12 l12" style="
                    padding-right: 30px;
                    padding-left: 30px;
                ">
                      <div class="card">
                        <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; background-color:#0d47a1" class="white-text"><b>Approval History</b></h6><hr style="margin: 0px">
                        <div class="card-content" style="padding: 10px; padding-top: 0px">
                          <table class="highlight" id="approver-dt-h">
                            <thead>
                              <tr>
                                  <th>Sequence</th> 
                                  <th>Approver Name</th> 
                                  <th>Status</th> 
                                  <th>Remarks</th> 
                                  <th>Action Date</th> 
                              </tr>
                            </thead>
                            <tbody></tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
            
              </div>

              <div class="row">
                <hr style="padding:1px;color:blue;background-color:blue">
                
                <div class="col s12 m12 l12">
                  <div class="input-field col s12 m10 l10">
                    <textarea class="materialize-textarea" type="text" id="app_remarks" name="remarks" placeholder="Please input remarks here.." style="height: 150px; border-left: 10px; border-color: black; padding-left:20px;" required></textarea>
                    <label for="icon_prefix2">Remarks</label>
                  </div>
                  
                  <div class="input-field col s12 m2 l2">
                    <button id="btnApp" name="approve" value="Approve" onclick="getStatus('Approved');" style="width: 100%; margin-bottom: 5px" class="green waves-effect waves-light btn"><i class="material-icons left">check_circle</i>Approve&nbsp;</button> <br> 
                    
                    <button id="btnRej" name="reject" value="Reject" onclick="getStatus('Reject');" style="width: 100%;  margin-bottom: 5px" class="red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>Reject&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button> <br> 
        
                    <a href="{{route('procedure.index')}}" style="width: 100%" class="modal-close orange waves-effect waves-dark btn"><i class="material-icons left">keyboard_return</i>Cancel&nbsp;&nbsp;&nbsp;</a>
                  </div>
                </div>
              </div>
            </div>

          </form>
        </div>
      </div>

  </div>
 
  <!-- SCRIPTS -->
  <script type="text/javascript" src="{{ asset('datatables/datatables.js') }}"></script>
  <script type="text/javascript">

    var searchInput = 'rev_complete_address';

    $(document).ready(function () {


        $('#rev_description').trigger('autoresize');

        document.onmousedown = disableRightclick;
        var message = "Right click is not allowed in this page";
        function disableRightclick(evt){
          if(evt.button == 2){
              alert(message);
              return false;    
          }
        }

        document.onkeydown = function(e) {
              if(event.keyCode == 123) {
                return false;
              }
              if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
                return false;
              }
              if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
                return false;
              }
              if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)){
                return false;
              }
              if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
                return false;
              }
        }

        $.get('../../getApproverMatrix/'+{{$procedures->id}}, function(response){
          
          var AppendString = "";
          var AppendStringH = "";
          var i  = "", j = "", k  = "", l  = "";
          var data = response.data;
          var dataMatrix = data.matrix;
          var dataMatrixH = data.matrix_h;
          
          var matrix = JSON.parse(dataMatrix);
          var matrixH = JSON.parse(dataMatrixH);

          var myTable = document.getElementById("approver-dt");
          var myTableH = document.getElementById("approver-dt-h");
          
          var rowCount = myTable.rows.length;
          for (var x=rowCount-1; x>0; x--) 
            {
              myTable.deleteRow(x); 
            }

          var rowCountH = myTableH.rows.length;
          for (var x=rowCountH-1; x>0; x--) 
            {
              myTableH.deleteRow(x); 
            }

          for(i in matrix)
            {
              for(j in matrix[i].sequence)
              {
                AppendString += 
                "<tr><td>" + matrix[i].sequence + 
                "</td><td>" + matrix[i].approver_emp_no + 
                "</td><td>" + matrix[i].approver_name + 
                      '<input type="hidden" name="app_seq[]" value="'+matrix[i].sequence+'"/>' + 
                      '<input type="hidden" name="app_id[]" value="'+matrix[i].approver_emp_no+'"/>'+
                      '<input type="hidden" name="app_fname[]" value="'+matrix[i].approver_name+'"/>'+
                      '<input type="hidden" name="app_nstatus[]" value="'+matrix[i].next_status+'"/>'+
                      '<input type="hidden" name="app_gate[]" value="'+matrix[i].is_gate+'"/>'+
                "</td></tr>";
              }
            }
            
          for(k in matrixH)
            {
              for(l in matrixH[k].sequence)
              {
                AppendStringH += 
                "<tr><td>" + matrixH[k].sequence + 
                "</td><td>" + matrixH[k].approver_emp_no + 
                "</td><td>" + matrixH[k].approver_name + 
                "</td><td>" + matrixH[k].remarks + 
                "</td><td>" + matrixH[k].action_date + 
                      '<input type="hidden" name="app_seq[]" value="'+matrixH[k].sequence+'"/>' + 
                      '<input type="hidden" name="app_id[]" value="'+matrixH[k].approver_emp_no+'"/>'+
                      '<input type="hidden" name="app_fname[]" value="'+matrixH[k].approver_name+'"/>'+
                      '<input type="hidden" name="app_nstatus[]" value="'+matrixH[k].next_status+'"/>'+
                      '<input type="hidden" name="app_gate[]" value="'+matrixH[k].is_gate+'"/>'+
                "</td></tr>";
              }
            }


          
          $('#approver-dt').find('tbody').append(AppendString);
          $('#approver-dt-h').find('tbody').append(AppendStringH);

        });
    });

    function getStatus(status)
    {
      var stat = status;
      $('#status').val(stat);
    }

    var procedures = $('#revisions-dt').DataTable({
        "lengthChange": false,
        "pageLength": 15,
        "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
        "pagingType": "full",
        "ajax": "/api/reiss/procedure/all_revision/{{$procedures->document_no}}",
        "columns": [
          {  "data": "id" },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  return '<a href="../../view/'+row.procedures.id+'/{{$loc}}">'+ row.document_no +'</a>';
                }
            },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.document_title;
                }
            },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.dpr_code;
                }
            },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.revision_no;
                }
            },
            {   "data": "status",
                "render": function ( data, type, row, meta ) {
                  switch(data){
                    case 'Approved':
                      return  '<span class="new badge green white-text" data-badge-caption="">Approved</span>';
                    break;
                    case 'Pending':
                      return  '<span class="new badge blue white-text" data-badge-caption="">Pending</span>';
                    break;
                    case 'Created':
                      return  '<span class="new badge green white-text" data-badge-caption="">Created</span>';
                    break;
                    case 'Obsolete':
                      return  '<span class="new badge black white-text" data-badge-caption="">Obsolete</span>';
                    break;
                    case 'Rejected':
                      return  '<span class="new badge red white-text" data-badge-caption="">Rejected</span>';
                    break;
                  }
                   
                }
            } 
            ]
        });
     

 

  </script>

  <!-- End of SCRIPTS -->

@endsection
