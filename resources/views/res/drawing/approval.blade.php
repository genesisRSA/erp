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
        <h4 class="title"><span class="grey-text darken-4">Document Control Centre<i class="material-icons">arrow_forward_ios</i></span><span class="grey-text darken-4">Drawings<i class="material-icons">arrow_forward_ios</i></span>Drawing Approval</h4>
    </div>
  </div>
 
  <div class="m-3 main-content">  
    <ul id="drawing_tab" class="tabs tabs-fixed-width tab-demo z-depth-1">
      <li class="tab col s12 m4 l4"><a class="active" href="#drawing">Drawing Details</a></li>
      <li class="tab col s12 m4 l4"><a href="#signatories">signatories</a></li>
    </ul>
      <div class="card" style="margin-top: 0px">
        <div class="card-body">
          <form method="POST" action="{{route('drawing.approve')}}" enctype="multipart/form-data">
          {{-- <form> --}}
            @csrf
            <div class="row">
              {{-- hidden items --}}
                <input type="hidden" id="id_app"              name="id"                    value="{{$drawings->id}}"/>
                <input type="hidden" id="seq_app"             name="seq"                   value="{{$drawings->current_sequence}}"/>
                <input type="hidden" id="appid_app"           name="appid"                 value="{{$drawings->current_approver}}"/>

              @if($drawings->revision_no!=0)
                <input type="hidden" id="ecn_code_h"           name="ecn_code_h"           value="{{$drawings_h->ecn_code}}"/>
                <input type="hidden" id="cust_code_h"          name="cust_code_h"          value="{{$drawings_h->cust_code}}"/>
                <input type="hidden" id="project_code_h"       name="project_code_h"       value="{{$drawings_h->project_code}}"/>
                <input type="hidden" id="drawing_no_h"         name="drawing_no_h"         value="{{$drawings_h->drawing_no}}"/>
                <input type="hidden" id="revision_no_h"        name="revision_no_h"        value="{{$drawings_h->revision_no}}"/>
                <input type="hidden" id="revision_date_h"      name="revision_date_h"      value="{{$drawings_h->revision_date}}"/>
                <input type="hidden" id="process_specs_h"      name="process_specs_h"      value="{{$drawings_h->process_specs}}"/>
                <input type="hidden" id="change_description_h" name="change_description_h" value="{{$drawings_h->change_description}}"/>
                <input type="hidden" id="change_reason_h"      name="change_reason_h"      value="{{$drawings_h->change_reason}}"/>
                <input type="hidden" id="assy_code_h"          name="assy_code_h"          value="{{$drawings_h->assy_code}}"/>
                <input type="hidden" id="fab_code_h"           name="fab_code_h"           value="{{$drawings_h->fab_code}}"/>
                <input type="hidden" id="created_by_h"         name="created_by_h"         value="{{$drawings_h->created_by}}" />
                <input type="hidden" id="approved_by_h"        name="approved_by_h"        value="{{$drawings_h->approved_by}}" />
                <input type="hidden" id="status_h"             name="status_h"             value="{{$drawings_h->status}}"/>
                <input type="hidden" id="file_name_h"          name="file_name_h"          value="{{$drawings_h->file_name}}" />
              @endif

                <input type="hidden" id="created_by"           name="created_by"           value="{{$drawings->created_by}}" />
                <input type="hidden" id="file_name"            name="file_name"            value="{{$drawings->file_name}}" />
                <input type="hidden" id="status"               name="status">
              {{-- hidden items --}}
              <div id="drawing" name="drawing">
                <br>
                <div class="row">
                  <div class="col s12 m12 l12">

                    <div class="col s12 m12 l12">
                      <div class="input-field col s12 m3 l3">
                        <input type="text" id="app_ecn_code" name="ecn_code" value="{{$drawings->ecn_code}}" readonly/>
                        <label for="ecn_code">ECN No.<sup class="red-text"></sup></label>
                      </div>
  
                      <div class="input-field col s12 m3 l3">
                        <input type="text" id="app_designer" name="designer" value="{{$employee->full_name}}" readonly/>
                        <label for="ecn_code">Designer<sup class="red-text"></sup></label>
                      </div> 
                       
                      <div class="input-field col s12 m3 l3">
                        <input type="text" id="app_revision_no" name="revision_no" value="{{$drawings->revision_no}}" placeholder=" " readonly/>
                        <label for="revision_no">Revision No.<sup class="red-text"></sup></label>
                      </div>
  
                      <div class="input-field col s12 m3 l3">
                        <input type="text" id="app_revision_date" name="revision_date" value="{{$drawings->revision_date}}" readonly/>
                        <label for="revision_date">Revision Date<sup class="red-text"></sup></label>
                      </div> 
                    </div>
  
                    <div class="col s12 m12 l12">                  
                      <div class="input-field col s12 m6 l6">
                        <input type="text" id="app_cust_code" name="cust_code" value="{{$drawings->cust_code}}" readonly/>
                        <label for="cust_code">Customer<sup class="red-text"> </sup></label>
                      </div>
  
                      <div class="input-field col s12 m6 l6">
                        <input type="text" id="app_project_code" name="project_code" value="{{$projects->project_name}}" readonly/>
                        <label for="project_code">Project Name<sup class="red-text"> </sup></label>
                      </div>
                    </div>
  
                    <div class="col s12 m12 l12">
                      <div class="input-field col s12 m4 l4">
                        <input type="hidden" id="app_assy_code" name="assy_code" value="{{$assy->assy_code}}" readonly/>
                        <input type="text" id="assy_desc" name="assy_desc" value="{{$assy->assy_desc}}" readonly/>
                        <label for="assy_desc">Assembly Description<sup class="red-text"> </sup></label>
                      </div>
                      
                      <div class="input-field col s12 m4 l4">
                        <input type="hidden" id="app_fab_code" name="fab_code" value="{{$fab->fab_code}}" readonly/>
                        <input type="text" id="fab_desc" name="fab_desc" value="{{$fab->fab_desc}}" readonly/>
                        <label for="fab_desc">Fabrication Description<sup class="red-text"> </sup></label>
                      </div>
  
                      <div class="input-field col s12 m4 l4">
                        <input type="text" id="app_drawing_no" name="drawing_no" value="{{$drawings->drawing_no}}" readonly/>
                        <label for="drawing_no">Drawing No. / Assembly Name<sup class="red-text"></sup></label>
                      </div>
                    </div>
  
                    <div class="col s12 m12 l12">
                      <div class="input-field col s12 m6 l6">
                        <input type="text" id="app_part_name" name="part_name" value="{{$drawings->part_name}}" readonly/>
                        <label for="v">Part Name / BOM / Module Name<sup class="red-text"> </sup></label>
                      </div>
  
                      <div class="input-field col s12 m6 l6">
                        <input type="text" id="app_process_specs" name="process_specs" value="{{$drawings->process_specs}}" readonly/>
                        <label for="process_specs">Existing Process Specification(s)<sup class="red-text"> </sup></label>
                      </div>
                    </div>
  
                    <div class="col s12 m12 l12">
                      <div class="input-field col s12 m6 l6">
                          <textarea id="app_change_description" name="change_description" class="materialize-textarea" placeholder="Some text here.." style="padding-bottom: 0px; margin-bottom: 10px;" required readonly>{{$drawings->change_description}}</textarea>
                          <label for="change_description">Description of Change(s)<sup class="red-text"> </sup></label>
                      </div>
  
                      <div class="input-field col s12 m6 l6">
                          <textarea id="app_change_reason" name="change_reason" class="materialize-textarea"  placeholder="Some text here.." style="padding-bottom: 0px; margin-bottom: 10px;" required readonly>{{$drawings->change_reason}}</textarea>
                          <label for="change_reason">Reason for Change / Revision<sup class="red-text"> </sup></label>
                      </div>
                    </div>
                      
                    <div class="col s12 m12 l12">
                      <h6 style="padding: 10px; padding-top: 20px; padding-left: 10px; padding-right: 10px; margin-bottom: 0px; background-color:#0d47a1" class="white-text"><b>Drawing Attachment(s)</b></h6>  
                      <div class="col s12 m12 l12">

                        </div>
                        {{-- <div class="row"> --}}
                          <br>
                          <div style="width:93%; 
                                      height:40%; 
                                      z-index: 10; 
                                      opacity:0.15;
                                      position:absolute; 
                                      text-align:center;
                                      line-height:300px;
                                      font-size:130px; 
                                      color:blue;">
                              &nbspRSA PROPERTY
                              &nbspRSA PROPERTY
                            </div>
                        {{-- </div> --}}
          
                          <embed
                              src="{{ action('DrawingsController@getDocument', ['id'=> $idx, 'stat' => $drawings->status, 'loc' => $loc, 'cc' => $cc = $loc == 'cc' ? $drawingx->copy_no : 0 ]) }}#toolbar=0"
                              style="width:100%; 
                                    height:90%; 
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
                        
                                    <th>Drawing No.</th>
                                    <th>Part Name</th>
                                    <th>ECN No.</th>
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
        
                    <a href="{{route('drawing.index', ['#approval'])}}" style="width: 100%" class="modal-close orange waves-effect waves-dark btn"><i class="material-icons left">keyboard_return</i>Cancel&nbsp;&nbsp;&nbsp;</a>
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

    var searchInput = 'complete_address';

    $(document).ready(function () {


        $('#description').trigger('autoresize');

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

        $.get('../../getApproverMatrix/'+{{$drawings->id}}, function(response){
          
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

    var drawings = $('#revisions-dt').DataTable({
        "lengthChange": false,
        "pageLength": 15,
        "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
        "pagingType": "full",
        "ajax": "/api/reiss/drawing/all_revision/{{Illuminate\Support\Facades\Crypt::encrypt($drawings->drawing_no)}}",
        "columns": [
          
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                if(row.status=='Approved' || row.status=='Created'){
                  return '<a href="../../view/'+row.drawings+'/{{$loc}}">'+ row.drawing_no +'</a>';
                }else{
                  return row.drawing_no;
                }  
              }
            },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.part_name;
              }
            },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                if(row.status=='Approved' || row.status=='Created'){
                  return '<a href="../../view/'+row.drawings+'/{{$loc}}">'+ row.ecn_code +'</a>';
                }else{
                  return row.ecn_code;
                }
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
                    case 'Received':
                        return  '<span class="new badge deep-orange lighten-1 white-text" data-badge-caption="">Received</span>';
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
