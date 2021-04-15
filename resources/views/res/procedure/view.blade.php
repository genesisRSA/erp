@extends('layouts.resmain')
<style>
   textarea.materialize-textarea
        {
            height: 20% !important; 
        }
</style>

@section('content')<body oncontextmenu="return false;">
  <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h4 class="title"><span class="grey-text darken-4">Document Control Centre<i class="material-icons">arrow_forward_ios</i></span><span class="grey-text darken-4">Procedures<i class="material-icons">arrow_forward_ios</i></span>View Procedure</h4>
    </div>
  </div>
  
    <div class="m-3 main-content">  
      <ul id="procedure_tab" class="tabs tabs-fixed-width tab-demo z-depth-1">
        <li class="tab col s12 m4 l4"><a class="active" href="#procedure">Procedure Details</a></li>
        <li class="tab col s12 m4 l4"><a href="#signatories">signatories</a></li>
      </ul>
      
      <div class="card" style="margin-top: 0px">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
              @csrf
            <div class="row">
              <div id="procedure" name="procedure">
                <br>
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
                      <input type="text" id="rev_requested_date" name="requested_date" class="grey lighten-5" value="{{$employee->full_name}}" readonly/>
                      <label for="requested_date">Requested By<sup class="red-text"></sup></label>
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

                  <div class="col s12 m12 l12" >
                    <h6 style="padding: 10px; padding-top: 20px; padding-left: 20px; padding-right: 20px;   margin-top: 20px; background-color:#0d47a1" class="white-text"><b>Procedure Attachment(s)</b></h6>  
                  </div>

                  <div class="row">
                    <br>
                    <div class="col s12 l12 m12" style="width:96%; 
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

                    <embed
                        src="{{ action('ProceduresController@getDocument', ['id'=> $procedures->id, 'stat' => $procedures->status, 'loc' => $loc ]) }}#toolbar=0"
                        style="width:95%; 
                              height:130%; 
                              margin-left:2.5%;" type="application/pdf"
                        id = "pdf_file"
                        frameborder="1"
                        > 
                  </div>

                  <div class="col s12 m12 l12">
                    <h6 style="padding: 10px; padding-top: 20px; padding-left: 20px; padding-right: 20px;   margin-top: 0px; background-color:#0d47a1" class="white-text"><b>Revision History</b></h6>  
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
          
            <div id="signatories" name="signatories" class="row">
                <div class="row">
                  <div class="col s12 m12 l12" style="
                  padding-right: 10px;
                  padding-left: 10px;
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
                  padding-right: 10px;
                  padding-left: 10px;
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
              <div class="col s12 m9 l9"></div>
              <div class="col s12 m3 l3 right-align" style="padding-right: 10px">
              <a href="{{route('procedure.index')}}" class="red waves-effect waves-dark btn" style="
              margin-bottom: 30px; width: 100%
          "><i class="material-icons left">keyboard_return</i>Return</a>
              </div>
            </div>

            </form>
          </div>
        </div>

    
      </div>  
    </div>
  </div>

  <!-- SCRIPTS -->
  <script type="text/javascript" src="{{ asset('datatables/datatables.js') }}"></script>
  <script type="text/javascript">

    var searchInput = 'add_complete_address';

    
    function prepareFrame(test) {
                var ifrm = document.createElement("iframe");
                ifrm.setAttribute("src", test);
                ifrm.style.width = "640px";
                ifrm.style.height = "480px";
                document.body.appendChild(ifrm);
            }

    $(document).ready(function () {

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

        $('#add_description').trigger('autoresize');

        document.onmousedown = disableRightclick;
        var message = "Right click is not allowed in this page";
        function disableRightclick(evt){
          if(evt.button == 2){
              alert(message);
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
                 if(row.status=='Created'){
                  return '<a href="../../view/'+row.procedures.id+'/{{$loc}}">'+ row.document_no +'</a>';
                 }else{
                  return row.document_no;
                 }  
                }
            },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.document_title;
                }
            },
            {  "data": "id",
                "render": function ( data, type, row, meta ) {
                  if(row.status=='Created'){
                    return '<a href="../../view/'+row.procedures.id+'/{{$loc}}">'+ row.dpr_code +'</a>';
                  }else{
                    return row.dpr_code;
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
